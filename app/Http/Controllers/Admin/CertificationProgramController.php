<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificationProgram;
use App\Models\CertificationRequirement;
use App\Models\CertificationParticipant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificationProgramController extends Controller
{
    public function index(): View
    {
        $programs = CertificationProgram::withCount('requirements', 'participants')->latest()->paginate(15);
        return view('admin.certification-programs.index', compact('programs'));
    }

    public function create(): View
    {
        return view('admin.certification-programs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['created_by'] = $request->user()->id;
        $validated['updated_by'] = $request->user()->id;

        CertificationProgram::create($validated);

        return redirect()->route('admin.certification-programs.index')->with('status', 'Program sertifikasi berhasil dibuat.');
    }

    public function show(CertificationProgram $certificationProgram): View
    {
        $certificationProgram->load('requirements', 'participants.user');
        return view('admin.certification-programs.show', compact('certificationProgram'));
    }

    public function edit(CertificationProgram $certificationProgram): View
    {
        return view('admin.certification-programs.edit', compact('certificationProgram'));
    }

    public function update(Request $request, CertificationProgram $certificationProgram): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['updated_by'] = $request->user()->id;
        $certificationProgram->update($validated);

        return redirect()->route('admin.certification-programs.index')->with('status', 'Program diperbarui.');
    }

    public function destroy(CertificationProgram $certificationProgram): RedirectResponse
    {
        $certificationProgram->delete();
        return redirect()->route('admin.certification-programs.index')->with('status', 'Program dihapus.');
    }

    // --- Requirements Management ---
    public function storeRequirement(Request $request, CertificationProgram $program): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string'],
            'type' => ['required', 'in:text,file'],
            'is_required' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $program->requirements()->create($validated);

        return redirect()->route('admin.certification-programs.show', $program)->with('status', 'Persyaratan ditambahkan.');
    }

    public function destroyRequirement(CertificationRequirement $requirement): RedirectResponse
    {
        $programId = $requirement->certification_program_id;
        $requirement->delete();
        return redirect()->route('admin.certification-programs.show', $programId)->with('status', 'Persyaratan dihapus.');
    }

    // --- Assignment Management ---
    public function assignParticipants(CertificationProgram $program): View
    {
        // Get all users (maybe filter by role if needed, currently all users)
        $users = User::orderBy('name')->get();
        // Pluck IDs of currently assigned
        $assignedIds = $program->participants()->pluck('participant_user_id')->toArray();

        return view('admin.certification-programs.assign', compact('program', 'users', 'assignedIds'));
    }

    public function storeParticipants(Request $request, CertificationProgram $program): RedirectResponse
    {
        $request->validate([
            'participants' => ['nullable', 'array'],
            'participants.*' => ['exists:users,id'],
        ]);

        $selectedIds = $request->participants ?? [];
        $currentParticipants = $program->participants()->pluck('participant_user_id')->toArray();

        $toAdd = array_diff($selectedIds, $currentParticipants);
        $toRemove = array_diff($currentParticipants, $selectedIds);

        // Remove unselected (only if pending)
        $program->participants()->whereIn('participant_user_id', $toRemove)->where('status', 'pending')->delete();

        // Add new
        foreach ($toAdd as $userId) {
            $program->participants()->create([
                'participant_user_id' => $userId,
                'status' => 'pending',
                'assigned_by' => $request->user()->id,
            ]);
        }

        return redirect()->route('admin.certification-programs.show', $program)->with('status', 'Peserta berhasil diupdate.');
    }

    // --- Submissions Review ---
    public function submissions(CertificationProgram $program): View
    {
        $submissions = $program->participants()->with('user')->whereIn('status', ['submitted', 'reviewed', 'approved', 'rejected'])->latest()->paginate(15);
        return view('admin.certification-programs.submissions', compact('program', 'submissions'));
    }

    public function showSubmission(CertificationParticipant $participant): View
    {
        $participant->load('program.requirements', 'answers', 'user');
        return view('admin.certification-programs.submission-detail', compact('participant'));
    }

    public function updateSubmissionStatus(Request $request, CertificationParticipant $participant): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:reviewed,approved,rejected'],
            'review_notes' => ['nullable', 'string'],
        ]);

        $participant->update($validated);

        if ($validated['status'] === 'approved') {
            // Generate certificate if not exists
            $existingCert = \App\Models\Certificate::where('participant_user_id', $participant->participant_user_id)
                ->where('certification_program_id', $participant->certification_program_id)
                ->first();

            if (!$existingCert) {
                // Get prefix: First 3 letters of program name, uppercase
                $programName = $participant->program->name;
                $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $programName), 0, 3));
                if (strlen($prefix) < 3) {
                    $prefix = str_pad($prefix, 3, 'X');
                }

                // Find latest certificate with this prefix
                $latestCert = \App\Models\Certificate::where('validation_code', 'like', $prefix . '-%')
                    ->orderBy('validation_code', 'desc')
                    ->first();

                $nextNumber = 0;
                if ($latestCert) {
                    $parts = explode('-', $latestCert->validation_code);
                    if (count($parts) === 2 && is_numeric($parts[1])) {
                        $nextNumber = (int) $parts[1] + 1;
                    }
                }

                $validationCode = $prefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

                \App\Models\Certificate::create([
                    'participant_user_id' => $participant->participant_user_id,
                    'project_id' => null,
                    'certification_program_id' => $participant->certification_program_id,
                    'issued_at' => now(),
                    'validation_code' => $validationCode,
                    'created_by' => $request->user()->id,
                    'updated_by' => $request->user()->id,
                ]);
            }
        }

        return redirect()->route('admin.certification-programs.submissions', $participant->certification_program_id)->with('status', 'Status submission diperbarui.');
    }
}
