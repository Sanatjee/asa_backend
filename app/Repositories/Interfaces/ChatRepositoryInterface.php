<?php

namespace App\Repositories\Interfaces;

use App\Enums\ChatSessionResolution;
use App\Models\ChatSession;


interface ChatRepositoryInterface
{

    public function createSession($userId);

    public function addMessage( ChatSession $session, $data );

    public function history( ChatSession $session );

    public function sessions();

    public function resolveSession(ChatSession $session);

    public function updateResolution( ChatSession $session, ChatSessionResolution $resolution ): ChatSession;

    public function total_sessions();
    
    public function active_sessions();

    public function resolved_sessions();

    public function followup_sessions();

    public function recent_conversations();

    public function session_trend();
    
}
