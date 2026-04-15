<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            Gate::authorize('permission', 'logs.view');

            return $next($request);
        });
    }

    public function index(Request $request): View
    {
        $logs = ActivityLog::query()
            ->with('user:id,name,email')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = (string) $request->string('q');
                $query->where(function ($sub) use ($q) {
                    $sub->where('description', 'like', "%{$q}%")
                        ->orWhere('route_name', 'like', "%{$q}%")
                        ->orWhere('url', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
                });
            })
            ->latest('id')
            ->paginate(30)
            ->withQueryString();

        return view('admin.logs.index', compact('logs'));
    }
}
