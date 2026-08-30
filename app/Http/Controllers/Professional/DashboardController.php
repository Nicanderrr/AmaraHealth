<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use App\Models\HealthArticle;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('professional.dashboard', [
            'assignedConsultations' => ConsultationRequest::query()
                ->where('assigned_professional_id', $user->id)
                ->latest('assigned_at')
                ->take(8)
                ->get(),
            'notifications' => Notification::query()
                ->where('recipient_id', $user->id)
                ->latest()
                ->take(8)
                ->get(),
            'draftArticles' => HealthArticle::query()
                ->where('author_id', $user->id)
                ->latest()
                ->take(6)
                ->get(),
            'caseCount' => ConsultationRequest::query()->where('assigned_professional_id', $user->id)->count(),
            'openCount' => ConsultationRequest::query()->where('assigned_professional_id', $user->id)->whereNotIn('status', ['closed'])->count(),
        ]);
    }
}
