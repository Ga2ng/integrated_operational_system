<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $action = $request->route()->getActionMethod();
            $map = [
                'index' => 'certificate.view',
                'create' => 'certificate.create',
                'store' => 'certificate.create',
                'edit' => 'certificate.update',
                'update' => 'certificate.update',
            ];
            if (isset($map[$action])) {
                Gate::authorize('permission', $map[$action]);
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $certificates = Certificate::query()->with(['participant', 'project'])->latest()->paginate(15);

        return view('admin.certificates.index', compact('certificates'));
    }

    public function create(): View
    {
        $participants = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        $projects = Project::query()->orderBy('name')->get();

        return view('admin.certificates.create', compact('participants', 'projects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['validation_code'] = strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('certificates', 'public');
        }

        Certificate::create($data);

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat dibuat.');
    }

    public function edit(Certificate $certificate): View
    {
        $participants = User::query()->orderBy('name')->get(['id', 'name', 'email']);
        $projects = Project::query()->orderBy('name')->get();

        return view('admin.certificates.edit', compact('certificate', 'participants', 'projects'));
    }

    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $data = $this->validated($request);
        $data['updated_by'] = $request->user()->id;

        if ($request->hasFile('document')) {
            if ($certificate->document_path) {
                Storage::disk('public')->delete($certificate->document_path);
            }
            $data['document_path'] = $request->file('document')->store('certificates', 'public');
        }

        $certificate->update($data);

        return redirect()->route('admin.certificates.index')->with('status', 'Sertifikat diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'participant_user_id' => ['required', 'exists:users,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
            'issued_at' => ['required', 'date'],
            'valid_until' => ['nullable', 'date', 'after_or_equal:issued_at'],
            'document' => ['nullable', 'file', 'max:5120'],
        ]);
    }
}
