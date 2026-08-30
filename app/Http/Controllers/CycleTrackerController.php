<?php

namespace App\Http\Controllers;

use App\Models\CycleEntry;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CycleTrackerController extends Controller
{
    public function index(): View
    {
        $entries = Auth::user()
            ->cycleEntries()
            ->latest('start_date')
            ->paginate(8);

        return view('tracker.index', [
            'entries' => $entries,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'flow_level' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = $request->user();
        $previousEntry = $user->cycleEntries()->latest('start_date')->first();
        $cycleLength = $previousEntry
            ? Carbon::parse($previousEntry->start_date)->diffInDays(Carbon::parse($data['start_date']))
            : null;
        $periodLength = ! empty($data['end_date'])
            ? Carbon::parse($data['start_date'])->diffInDays(Carbon::parse($data['end_date'])) + 1
            : null;

        $user->cycleEntries()->create([
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'cycle_length_days' => $cycleLength,
            'period_length_days' => $periodLength,
            'flow_level' => $data['flow_level'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()
            ->route('tracker.index')
            ->with('status', 'Cycle entry saved successfully.');
    }
}
