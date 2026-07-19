<?php

namespace App\Services;

use App\Repositories\Interfaces\ChatRepositoryInterface;

class DashboardService
{
    public function __construct(
        protected ChatRepositoryInterface $chatRepository
    ) {}

    public function dashboard()
    {   
        $total_sessions = $this->chatRepository->total_sessions();
        $active_sessions = $this->chatRepository->active_sessions();
        $resolved_sessions = $this->chatRepository->resolved_sessions();
        $followup_sessions = $this->chatRepository->followup_sessions();
        $recent_conversations = $this->chatRepository->recent_conversations();
        $session_trend = $this->chatRepository->session_trend();
        $resolution_trend = $this->chatRepository->resolutionTrend();
        $category_trend = $this->chatRepository->categoryTrend();

        return [
            "total_sessions" => $total_sessions,
            "active_sessions" => $active_sessions,
            "resolved_sessions" => $resolved_sessions,
            "followup_sessions" => $followup_sessions,
            "recent_conversations" => $recent_conversations,
            "session_trend" => $session_trend,
            "resolution_trend" => $resolution_trend,
            "category_trend" => $category_trend,
        ];
    }
}