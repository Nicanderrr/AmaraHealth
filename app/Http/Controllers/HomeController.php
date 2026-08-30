<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\ConsultationRequest;
use App\Models\ForumTopic;
use App\Models\HealthArticle;
use App\Models\HealthResource;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $heroImagePath = AppSetting::getValue('homepage_hero_image');
        $heroOverlayOpacity = (int) AppSetting::getValue('homepage_hero_overlay_opacity', '72');

        return view('home', [
            'heroImageUrl' => $heroImagePath ? asset('storage/'.$heroImagePath) : null,
            'heroOverlayOpacity' => max(0, min(100, $heroOverlayOpacity)),
            'featuredArticles' => HealthArticle::query()
                ->where('is_featured', true)
                ->latest('published_at')
                ->take(3)
                ->get(),
            'latestArticles' => HealthArticle::query()
                ->latest('published_at')
                ->take(3)
                ->get(),
            'latestResources' => HealthResource::query()
                ->where('is_verified', true)
                ->latest()
                ->take(3)
                ->get(),
            'latestTopics' => ForumTopic::query()
                ->where('is_hidden', false)
                ->latest()
                ->take(3)
                ->get(),
            'resourceCount' => HealthResource::query()->where('is_verified', true)->count(),
            'consultationCount' => ConsultationRequest::query()->count(),
        ]);
    }
}
