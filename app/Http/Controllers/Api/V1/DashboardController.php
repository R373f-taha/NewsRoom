<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;
      public function __construct(DashboardService  $dashboardService)
    {
        $this->dashboardService = $dashboardService;

    }

    public function stats()
    {
        $stats = $this->dashboardService->getDashboardStats();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard stats retrieved successfully 📊',
            'data' => $stats
        ]);
    }

     public function clearCache()
    {
        $this->dashboardService->clearDashboardStatsCache();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard stats cache cleared successfully 😊💛',
        ]);
    }

     public function mostActiveWriters()
    {
        $writers = $this->dashboardService->getMostActiveWriters(5);

        return response()->json([
            'success' => true,
            'message' => 'Most active writers retrieved successfully 😊💛',
            'data' => $writers
        ]);
    }

}
