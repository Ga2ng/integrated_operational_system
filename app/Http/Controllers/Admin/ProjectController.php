<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $action = $request->route()->getActionMethod();
            $map = [
                'index' => 'project.view',
                'show' => 'project.view',
                'create' => 'project.create',
                'store' => 'project.create',
                'edit' => 'project.update',
                'update' => 'project.update',
                'markCompleted' => 'project.update',
            ];
            if (isset($map[$action])) {
                Gate::authorize('permission', $map[$action]);
            }

            return $next($request);
        });
    }

    public function index(): View
    {
        $projects = Project::query()
            ->with('manager')
            ->withCount([
                'tasks as total_tasks',
                'tasks as completed_tasks' => fn ($query) => $query->where('status', 'completed'),
                'tasks as in_progress_tasks' => fn ($query) => $query->where('status', 'in_progress'),
                'tasks as pending_tasks' => fn ($query) => $query->where('status', 'pending'),
            ])
            ->latest()
            ->paginate(12);

        return view('admin.projects.index', compact('projects'));
    }

    public function show(Project $project): View
    {
        $project->load(['manager', 'tasks.createdBy']);
        
        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->where('status', 'completed')->count();
        $pendingTasks = $project->tasks->where('status', 'pending')->count();
        $inProgressTasks = $project->tasks->where('status', 'in_progress')->count();

        $progressPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        return view('admin.projects.show', compact(
            'project', 
            'totalTasks', 
            'completedTasks', 
            'pendingTasks', 
            'inProgressTasks', 
            'progressPercentage'
        ));
    }

    public function create(): View
    {
        $managers = User::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.projects.create', compact('managers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Proyek dibuat.');
    }

    public function edit(Project $project): View
    {
        if ($project->isCompleted()) {
            abort(403, 'Proyek yang sudah selesai tidak dapat diedit.');
        }

        $managers = User::query()->orderBy('name')->get(['id', 'name']);

        return view('admin.projects.edit', compact('project', 'managers'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        if ($project->isCompleted()) {
            return redirect()->route('admin.projects.show', $project)->with('error', 'Proyek yang sudah selesai tidak dapat diedit.');
        }

        $data = $this->validated($request);
        $data['updated_by'] = $request->user()->id;

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', 'Proyek diperbarui.');
    }

    public function markCompleted(Project $project, Request $request): RedirectResponse
    {
        if ($project->isCompleted()) {
            return redirect()->route('admin.projects.show', $project)->with('status', 'Proyek sudah berstatus selesai.');
        }

        $project->update([
            'status' => 'Selesai',
            'end_date' => $project->end_date ?? now()->toDateString(),
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.projects.show', $project)->with('status', 'Proyek ditandai selesai.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'scope_of_work' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'manager_user_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
