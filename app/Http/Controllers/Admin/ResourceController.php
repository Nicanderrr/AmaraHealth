<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\HealthResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        return view('admin.resources.index', [
            'resources' => HealthResource::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.resources.form', [
            'resource' => new HealthResource(),
            'action' => route('admin.resources.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        HealthResource::create($this->validatePayload($request));

        return redirect()->route('admin.resources.index')->with('status', 'Resource created.');
    }

    public function edit(HealthResource $resource): View
    {
        return view('admin.resources.form', [
            'resource' => $resource,
            'action' => route('admin.resources.update', $resource),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, HealthResource $resource): RedirectResponse
    {
        $resource->update($this->validatePayload($request));

        return redirect()->route('admin.resources.index')->with('status', 'Resource updated.');
    }

    public function destroy(HealthResource $resource): RedirectResponse
    {
        AuditLog::create([
            'admin_id' => request()->user()->id,
            'action' => 'delete_resource',
            'target_entity_type' => HealthResource::class,
            'target_entity_id' => (string) $resource->getKey(),
            'reason' => 'Removed via admin resource manager.',
        ]);

        $resource->delete();

        return back()->with('status', 'Resource deleted.');
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'description' => ['required', 'string'],
            'is_verified' => ['nullable', 'boolean'],
        ]);
    }
}
