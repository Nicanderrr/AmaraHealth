<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    private const HOMEPAGE_HERO_IMAGE = 'homepage_hero_image';
    private const HOMEPAGE_HERO_OVERLAY = 'homepage_hero_overlay_opacity';
    private const DEFAULT_HERO_OVERLAY = 72;
    private const PAGE_HERO_IMAGES = [
        'library' => ['label' => 'Library pages', 'setting' => 'page_hero_library_image'],
        'forum' => ['label' => 'Forum pages', 'setting' => 'page_hero_forum_image'],
        'tracker' => ['label' => 'Tracker page', 'setting' => 'page_hero_tracker_image'],
        'resources' => ['label' => 'Resources page', 'setting' => 'page_hero_resources_image'],
        'consultations' => ['label' => 'Consultation pages', 'setting' => 'page_hero_consultations_image'],
        'account' => ['label' => 'Login and register pages', 'setting' => 'page_hero_account_image'],
        'dashboard' => ['label' => 'Student dashboard', 'setting' => 'page_hero_dashboard_image'],
    ];

    public function edit(): View
    {
        $heroImagePath = AppSetting::getValue(self::HOMEPAGE_HERO_IMAGE);
        $heroOverlayOpacity = (int) AppSetting::getValue(self::HOMEPAGE_HERO_OVERLAY, (string) self::DEFAULT_HERO_OVERLAY);

        return view('admin.settings.homepage', [
            'heroImagePath' => $heroImagePath,
            'heroImageUrl' => $heroImagePath ? asset('storage/'.$heroImagePath) : null,
            'heroOverlayOpacity' => max(0, min(100, $heroOverlayOpacity)),
            'pageHeroImages' => collect(self::PAGE_HERO_IMAGES)
                ->map(function (array $page, string $key) {
                    $path = AppSetting::getValue($page['setting']);

                    return [
                        'key' => $key,
                        'label' => $page['label'],
                        'path' => $path,
                        'url' => $path ? asset('storage/'.$path) : null,
                    ];
                })
                ->values(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'hero_overlay_opacity' => ['required', 'integer', 'min:0', 'max:100'],
            'remove_hero_image' => ['nullable', 'boolean'],
            'page_hero_images' => ['nullable', 'array'],
            'page_hero_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_page_hero_images' => ['nullable', 'array'],
            'remove_page_hero_images.*' => ['nullable', 'boolean'],
        ]);

        $currentPath = AppSetting::getValue(self::HOMEPAGE_HERO_IMAGE);
        $newPath = $currentPath;

        if ($request->boolean('remove_hero_image')) {
            $this->deletePublicFile($currentPath);
            $newPath = null;
        }

        if ($request->hasFile('hero_image')) {
            $this->deletePublicFile($currentPath);
            $newPath = $request->file('hero_image')->store('homepage/hero', 'public');
        }

        AppSetting::setValue(self::HOMEPAGE_HERO_IMAGE, $newPath);
        AppSetting::setValue(self::HOMEPAGE_HERO_OVERLAY, (string) $validated['hero_overlay_opacity']);

        foreach (self::PAGE_HERO_IMAGES as $key => $page) {
            $currentPagePath = AppSetting::getValue($page['setting']);
            $newPagePath = $currentPagePath;

            if ($request->boolean("remove_page_hero_images.$key")) {
                $this->deletePublicFile($currentPagePath);
                $newPagePath = null;
            }

            if ($request->hasFile("page_hero_images.$key")) {
                $this->deletePublicFile($currentPagePath);
                $newPagePath = $request->file("page_hero_images.$key")->store("page-heroes/$key", 'public');
            }

            AppSetting::setValue($page['setting'], $newPagePath);
        }

        AuditLog::query()->create([
            'admin_id' => $request->user()->id,
            'action' => 'update_homepage_hero',
            'target_entity_type' => AppSetting::class,
            'target_entity_id' => null,
            'reason' => $validated['remove_hero_image'] ?? false
                ? 'Removed homepage hero image and updated hero settings.'
                : 'Updated hero settings.',
        ]);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Homepage hero settings updated.');
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
