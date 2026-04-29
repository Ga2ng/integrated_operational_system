<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProjectTaskController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {
        if ($project->isCompleted()) {
            return redirect()->route('admin.projects.show', $project)->with('error', 'Task tidak dapat ditambahkan karena proyek sudah selesai.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'], // Max 5MB
        ]);

        $task = new ProjectTask($validated);
        $task->project_id = $project->id;
        $task->status = 'pending';
        $task->created_by = $request->user()->id;
        $task->updated_by = $request->user()->id;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $task->file_path = $file->store('project-tasks', 'public');
            $task->file_type = $file->getClientOriginalExtension();
        }

        $task->save();

        return redirect()->route('admin.projects.show', $project)->with('status', 'Task berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, ProjectTask $projectTask): RedirectResponse
    {
        if ($projectTask->project && $projectTask->project->isCompleted()) {
            return redirect()->route('admin.projects.show', $projectTask->project_id)->with('error', 'Status task tidak dapat diubah karena proyek sudah selesai.');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,in_progress,completed'],
        ]);

        $projectTask->status = $validated['status'];
        $projectTask->updated_by = $request->user()->id;

        if ($validated['status'] === 'completed' && !$projectTask->completed_at) {
            $projectTask->completed_at = now();
        } elseif ($validated['status'] !== 'completed') {
            $projectTask->completed_at = null;
        }

        $projectTask->save();

        return redirect()->route('admin.projects.show', $projectTask->project_id)->with('status', 'Status task diperbarui.');
    }
}
