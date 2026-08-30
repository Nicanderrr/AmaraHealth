<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function createLogin(): View
    {
        return view('auth.login');
    }

    public function storeLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $identifier = trim($credentials['identifier']);
        $user = User::query()
            ->where('email', $identifier)
            ->orWhere('student_id', $identifier)
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['identifier' => 'These credentials do not match our records.'])
                ->onlyInput('identifier');
        }

        if ($user->account_status === 'suspended') {
            return back()
                ->withErrors(['identifier' => 'Your account has been suspended. Please contact the platform administrator for assistance.'])
                ->onlyInput('identifier');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        $user->forceFill(['last_login_at' => now()])->save();

        $intended = match (Auth::user()?->role) {
            'admin' => route('admin.dashboard'),
            'professional' => route('professional.dashboard'),
            default => route('dashboard'),
        };

        return redirect()->intended($intended);
    }

    public function createRegister(): View
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'digits:8', 'unique:users,student_id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['display_name'],
            'display_name' => $data['display_name'],
            'email' => 'student-'.$data['student_id'].'@amara.local',
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'student_id' => $data['student_id'],
            'student_id_hash' => hash('sha256', $data['student_id']),
            'account_status' => 'active',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
