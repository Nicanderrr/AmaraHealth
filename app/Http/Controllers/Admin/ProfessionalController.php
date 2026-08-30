<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfessionalController extends Controller
{
    public function index(): View
    {
        return view('admin.professionals.index', [
            'professionals' => User::query()->where('role', 'professional')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.professionals.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'professional_title' => ['required', 'string', 'max:80'],
            'university_email' => ['required', 'email', 'max:255', 'unique:users,university_email'],
            'assigned_categories' => ['required', 'array', 'min:1'],
            'assigned_categories.*' => ['string'],
        ]);

        $tempPassword = Str::random(10);

        User::create([
            'name' => $data['name'],
            'display_name' => 'Dr. '.Str::before($data['name'], ' '),
            'email' => $data['university_email'],
            'university_email' => $data['university_email'],
            'password' => Hash::make($tempPassword),
            'role' => 'professional',
            'professional_title' => $data['professional_title'],
            'assigned_categories' => $data['assigned_categories'],
            'account_status' => 'active',
            'availability' => 'available',
        ]);

        AuditLog::create([
            'admin_id' => $request->user()->id,
            'action' => 'create_professional',
            'target_entity_type' => User::class,
            'target_entity_id' => $data['university_email'],
            'reason' => 'Temporary password: '.$tempPassword,
        ]);

        return redirect()->route('admin.professionals.index')->with('status', 'Professional account created. Temporary password: '.$tempPassword);
    }
}
