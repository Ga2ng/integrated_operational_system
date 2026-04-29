<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\MaterialInventory;
use App\Models\Project;
use App\Models\Rfq;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Gate::authorize('permission', 'dashboard.view');

            return $next($request);
        });
    }

    public function index(): View
    {
        // 1. Chart Data: RFQ Trends (Last 6 Months)
        $rfqTrends = Rfq::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')->toArray();
        
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months->put(now()->subMonths($i)->format('M'), $rfqTrends[$month] ?? 0);
        }

        // 2. Chart Data: Project Status Distribution
        $projectStatus = Project::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')->toArray();

        return view('admin.dashboard', [
            'projectCount' => Project::query()->count(),
            'pendingRfqCount' => Rfq::query()->where('status', 'pending')->count(),
            'inventoryCount' => MaterialInventory::query()->count(),
            'certifiedUsersCount' => Certificate::query()->count(),
            'recentCertificates' => Certificate::query()->with('participant')->latest()->limit(5)->get(),
            'recentRfqs' => Rfq::query()->latest()->limit(5)->get(),
            
            // Chart Data
            'rfqChartLabels' => $months->keys(),
            'rfqChartData' => $months->values(),
            
            'projectStatusLabels' => array_keys($projectStatus),
            'projectStatusData' => array_values($projectStatus),
        ]);
    }
}
