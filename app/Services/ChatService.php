<?php

namespace App\Services;

use App\Enums\ChatSender;
use App\Enums\ChatSessionResolution;
use App\Models\User;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ChatService
{
    public function __construct(
        protected AIService $aiService,
        protected ChatRepositoryInterface $chatRepository
    ) {}


    public function createSession(User $user): ChatSession
    {
        return $this->chatRepository->createSession($user->id);
    }

    public function listSessions(User $user)
    {
        $query = ChatSession::with([
            'user',
            'messages' => function ($q) {
                $q->latest()->limit(1);
            }
        ])->latest();

        if (!$user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        return $query->get();
    }

    public function authorizeSession(
        User $user,
        ChatSession $session
    ): void {

        if (
            !$user->hasRole('Admin') &&
            $session->user_id != $user->id
        ) {
            throw new HttpException(
                403,
                'Unauthorized.'
            );
        }
    }

    public function sendMessage(
        User $user,
        ChatSession $session,
        string $question
    ) {
        return DB::transaction(function () use (
            $session,
            $question
        ) {

            $userMessage = ChatMessage::create([
                'chat_session_id' => $session->id,
                'sender' => ChatSender::USER,
                'message' => $question,
            ]);


            // Magic happens here
            $response = $this->aiService->answer($question);


            $assistantMessage = ChatMessage::create([
                'chat_session_id' => $session->id,
                'sender' => ChatSender::ASSISTANT,
                'message' => $response['message'],
            ]);

            if (isset($response['needs_followup']) && $response['needs_followup']) {
                $this->chatRepository->updateResolution(
                    $session,
                    ChatSessionResolution::FOLLOWUP
                );
            }


            return [
                'user_message' => $userMessage,
                'assistant_message' => $assistantMessage,
                'session' => $session->fresh(),
            ];
        });
    }

    public function resolveSession(ChatSession $session): ChatSession
    {
        return $this->chatRepository->resolveSession($session);
    }

    /**
     * Delete session
     */
    public function deleteSession(
        ChatSession $session
    ): void {

        $session->messages()->delete();

        $session->delete();
    }
}
