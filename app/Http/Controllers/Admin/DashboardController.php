<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use App\Models\ForumTopic;
use App\Models\HealthArticle;
use App\Models\HealthResource;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $consultationsQuery = ConsultationRequest::query();
        $lastSevenDays = collect(range(6, 0))->map(function (int $offset) {
            $date = now()->subDays($offset)->startOfDay();

            return [
                'date' => $date->toDateString(),
                'label' => $date->format('D'),
                'short' => $date->format('M j'),
            ];
        });

        $trendCounts = $lastSevenDays->mapWithKeys(function (array $day) {
            $date = Carbon::parse($day['date']);

            return [
                $day['date'] => ConsultationRequest::query()
                    ->whereBetween('created_at', [$date->copy()->startOfDay(), $date->copy()->endOfDay()])
                    ->count(),
            ];
        });

        $statusOrder = ['submitted', 'assigned', 'under_review', 'awaiting_student_response', 'response_ready', 'closed', 'unassigned'];
        $statusCounts = collect($statusOrder)->mapWithKeys(function (string $status) use ($consultationsQuery) {
            return [$status => (clone $consultationsQuery)->where('status', $status)->count()];
        });
        $statusLabels = [
            'submitted' => 'Submitted',
            'assigned' => 'Assigned',
            'under_review' => 'Under review',
            'awaiting_student_response' => 'Awaiting response',
            'response_ready' => 'Response ready',
            'closed' => 'Closed',
            'unassigned' => 'Unassigned',
        ];

        return view('admin.dashboard', [
            'students' => User::query()->where('role', 'student')->count(),
            'professionals' => User::query()->where('role', 'professional')->count(),
            'suspendedAccounts' => User::query()->where('account_status', 'suspended')->count(),
            'articles' => HealthArticle::query()->count(),
            'resources' => HealthResource::query()->count(),
            'consultations' => (clone $consultationsQuery)->count(),
            'openConsultations' => (clone $consultationsQuery)->whereIn('status', ['submitted', 'assigned', 'under_review', 'awaiting_student_response'])->count(),
            'topics' => ForumTopic::query()->count(),
            'latestConsultations' => ConsultationRequest::query()->with('assignedProfessional')->latest()->take(5)->get(),
            'latestTopics' => ForumTopic::query()->latest()->take(5)->get(),
            'consultationTrendLabels' => $lastSevenDays->pluck('short')->all(),
            'consultationTrendValues' => $lastSevenDays->map(fn (array $day) => $trendCounts[$day['date']] ?? 0)->all(),
            'consultationStatusLabels' => collect($statusLabels),
            'consultationStatusCounts' => $statusCounts,
        ]);
    }
}
