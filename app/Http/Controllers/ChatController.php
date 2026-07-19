<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use Illuminate\Http\Request;
use App\Services\ChatService;

class ChatController extends Controller
{
    public function __construct(
        protected ChatService $service
    ) {}

    /**
     * Start a new chat session
     */
    public function create(Request $request)
    {
        $session = $this->service->createSession(
            auth()->user()
        );

        return response()->json([
            'success' => true,
            'message' => 'Chat session created successfully.',
            'data' => $session,
        ], 201);
    }


    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->listSessions(
                auth()->user()
            ),
        ]);
    }

    /**
     * Show a chat session with all messages
     */
    public function show(ChatSession $chatSession)
    {
        $this->service->authorizeSession(
            auth()->user(),
            $chatSession
        );

        return response()->json([
            'success' => true,
            'data' => $chatSession->load([
                'user',
                'messages' => function ($query) {
                    $query->orderBy('created_at');
                }
            ]),
        ]);
    }


    public function send(Request $request, ChatSession $chatSession)
    {

        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $this->service->authorizeSession(
            auth()->user(),
            $chatSession
        );

        $messages = $this->service->sendMessage(
            auth()->user(),
            $chatSession,
            $request->message
        );

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $messages,
        ]);
    }

    public function sendSupportReply(Request $request, ChatSession $chatSession)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $data = $this->service->sendSupportReply(
            auth()->user(),
            $chatSession,
            $request->message
        );

        return response()->json([
            'message' => 'Reply sent successfully.',
            'data' => $data,
        ]);
    }


    public function destroy(ChatSession $chatSession)
    {
        $this->service->authorizeSession(
            auth()->user(),
            $chatSession
        );

        $this->service->deleteSession(
            $chatSession
        );

        return response()->json([
            'success' => true,
            'message' => 'Chat session deleted successfully.',
        ]);
    }

    public function resolve(ChatSession $chatSession)
    {
        $this->service->authorizeSession(
            auth()->user(),
            $chatSession
        );

        $session = $this->service->resolveSession($chatSession);

        return response()->json([
            'success' => true,
            'message' => 'Chat resolved successfully.',
            'data' => $session,
        ]);
    }
}
