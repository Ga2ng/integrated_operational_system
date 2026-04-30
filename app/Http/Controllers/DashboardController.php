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

        // 1. Chart Data: RFQ Status for User
        $rfqStatus = $user->rfqsAsClient()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')->toArray();

        // Pending Certifications
        $pendingCertifications = \App\Models\CertificationParticipant::with('program')
            ->where('participant_user_id', $user->id)
            ->whereIn('status', ['pending', 'rejected'])
            ->latest()
            ->get();

        return view('dashboard', [
            'rfqs' => $user->rfqsAsClient()->latest()->limit(5)->get(),
            'certificates' => $user->certificatesAsParticipant()->latest()->limit(5)->get(),
            'pendingCertifications' => $pendingCertifications,
            'rfqStatusLabels' => array_keys($rfqStatus),
            'rfqStatusData' => array_values($rfqStatus),
            'totalRfqs' => array_sum($rfqStatus),
        ]);
    }
}
