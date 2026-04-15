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
        return view('admin.dashboard', [
            'projectCount' => Project::query()->count(),
            'pendingRfqCount' => Rfq::query()->where('status', 'pending')->count(),
            'inventoryCount' => MaterialInventory::query()->count(),
            'recentCertificates' => Certificate::query()->with('participant')->latest()->limit(5)->get(),
        ]);
    }
}
