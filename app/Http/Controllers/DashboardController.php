<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        return response()->json([
            "success" => true,
            "data" => $this->dashboardService->dashboard()
        ]);
    }
}
