<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CertificationParticipant;
use App\Models\CertificationAnswer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MyCertificationController extends Controller
{
    public function index(Request $request): View
    {
        $certifications = CertificationParticipant::with('program')
            ->where('participant_user_id', $request->user()->id)
            ->latest()
            ->paginate(10);
            
        return view('customer.my-certifications.index', compact('certifications'));
    }

    public function show(Request $request, CertificationParticipant $participant): View
    {
        // Ensure user owns this
        if ($participant->participant_user_id !== $request->user()->id) {
            abort(403);
        }

        $participant->load('program.requirements', 'answers');
        
        $certificate = null;
        if ($participant->status === 'approved') {
            $certificate = \App\Models\Certificate::where('participant_user_id', $participant->participant_user_id)
                ->where('certification_program_id', $participant->certification_program_id)
                ->first();
        }

        return view('customer.my-certifications.show', compact('participant', 'certificate'));
    }

    public function store(Request $request, CertificationParticipant $participant): RedirectResponse
    {
        // Ensure user owns this
        if ($participant->participant_user_id !== $request->user()->id) {
            abort(403);
        }

        if ($participant->status !== 'pending' && $participant->status !== 'rejected') {
            return back()->with('error', 'Sertifikasi ini sudah dikirim.');
        }

        $program = $participant->program()->with('requirements')->first();
        
        $rules = [];
        foreach ($program->requirements as $req) {
            $rule = $req->is_required ? 'required' : 'nullable';
            if ($req->type === 'file') {
                $rules['req_' . $req->id] = [$rule, 'file', 'max:5120']; // Max 5MB
            } else {
                $rules['req_' . $req->id] = [$rule, 'string'];
            }
        }

        $validated = $request->validate($rules);

        foreach ($program->requirements as $req) {
            $inputName = 'req_' . $req->id;
            
            $answer = CertificationAnswer::firstOrNew([
                'certification_participant_id' => $participant->id,
                'certification_requirement_id' => $req->id,
            ]);

            if ($req->type === 'file') {
                if ($request->hasFile($inputName)) {
                    $answer->file_path = $request->file($inputName)->store('certification-uploads', 'public');
                }
            } else {
                $answer->answer_text = $validated[$inputName] ?? null;
            }

            $answer->save();
        }

        $participant->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('dashboard.my-certifications.index')->with('status', 'Sertifikasi berhasil disubmit. Menunggu review dari Admin.');
    }
}
