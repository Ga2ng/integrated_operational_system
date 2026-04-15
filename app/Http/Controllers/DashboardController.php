<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $user = auth()->user();
        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->canAccessAdminPanel()) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard', [
            'rfqs' => $user->rfqsAsClient()->latest()->limit(10)->get(),
            'certificates' => $user->certificatesAsParticipant()->latest()->limit(10)->get(),
        ]);
    }
}
