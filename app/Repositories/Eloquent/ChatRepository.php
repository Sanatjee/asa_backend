<?php

namespace App\Repositories\Eloquent;

use App\Enums\ChatSessionResolution;
use App\Enums\ChatSessionStatus;
use App\Models\ChatSession;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChatRepository implements ChatRepositoryInterface
{

    public function createSession($userId)
    {
        return ChatSession::create([
            'user_id' => $userId,
            'started_at' => now(),
            'status' => 'active',
            'resolution_flag' => ChatSessionResolution::UNRESOLVED,
        ]);
    }

    public function addMessage(
        ChatSession $session,
        $data
    ) {
        return $session->messages()->create($data);
    }

    public function history(
        ChatSession $session
    ) {

        return $session->messages()->latest()->get();
    }

    public function sessions()
    {
        return ChatSession::with('user')->latest()->paginate(15);
    }

    public function resolveSession(ChatSession $session): ChatSession
    {
        $session->update([
            'status' => ChatSessionStatus::INACTIVE,
            'completed_at' => now(),
            'resolution_flag' => ChatSessionResolution::RESOLVED,
        ]);

        return $session->fresh();
    }

    public function updateResolution( ChatSession $session, ChatSessionResolution $resolution ): ChatSession 
    {
        $session->update([
            'status' => ChatSessionStatus::ACTIVE,
            'completed_at' => $resolution === ChatSessionResolution::FOLLOWUP
                ? now()
                : null,
            'resolution_flag' => $resolution,
        ]);

        return $session->fresh();
    }

    public function total_sessions(){
        return ChatSession::count();
    }
    
    public function active_sessions(){
        return ChatSession::whereIn('resolution_flag', [
            ChatSessionResolution::FOLLOWUP,
            ChatSessionResolution::UNRESOLVED,
        ])->count();
    }

    public function resolved_sessions(){
        return ChatSession::where('resolution_flag', ChatSessionResolution::RESOLVED)->count();
    }

    public function followup_sessions(){
        return ChatSession::where('resolution_flag', ChatSessionResolution::FOLLOWUP)->count();
    }

    public function recent_conversations(){
        return ChatSession::with([ "user", "messages" ])->latest()->take(10)->get();
    }

    public function session_trend(){
        return ChatSession::select( DB::raw("DATE(created_at) as date"), DB::raw("COUNT(*) as count") )
                ->groupBy("date")
                ->orderBy("date")
                ->get();
    }
}
