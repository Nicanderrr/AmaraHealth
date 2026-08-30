<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use App\Models\ForumTopic;
use App\Models\HealthArticle;
use App\Models\HealthResource;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user?->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user?->role === 'professional') {
            return redirect()->route('professional.dashboard');
        }

        $entries = $user->cycleEntries()->latest('start_date')->take(6)->get()->sortBy('start_date')->values();
        $prediction = $this->predictNextCycle($entries);

        return view('dashboard', [
            'latestEntries' => $entries->take(-4),
            'prediction' => $prediction,
            'consultations' => $user->consultationRequests()->with('assignedProfessional')->latest()->take(4)->get(),
            'topics' => $user->forumTopics()->where('is_hidden', false)->latest()->take(4)->get(),
            'articleCount' => HealthArticle::query()->count(),
            'resourceCount' => HealthResource::query()->where('is_verified', true)->count(),
            'topicCount' => ForumTopic::query()->where('is_hidden', false)->count(),
            'consultationCount' => ConsultationRequest::query()->count(),
        ]);
    }

    private function predictNextCycle(Collection $entries): array
    {
        $latest = $entries->last();
        $intervals = $entries->pluck('cycle_length_days')->filter();
        $averageCycle = $intervals->isNotEmpty() ? (int) round($intervals->avg()) : 28;

        if (! $latest) {
            return [
                'next_start' => null,
                'average_cycle' => $averageCycle,
                'average_period' => 5,
            ];
        }

        $periodLengths = $entries->pluck('period_length_days')->filter();
        $averagePeriod = $periodLengths->isNotEmpty() ? (int) round($periodLengths->avg()) : 5;

        return [
            'next_start' => Carbon::parse($latest->start_date)->addDays($averageCycle),
            'average_cycle' => $averageCycle,
            'average_period' => $averagePeriod,
        ];
    }
}
