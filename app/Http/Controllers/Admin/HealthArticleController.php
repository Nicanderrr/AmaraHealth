<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\HealthArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HealthArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => HealthArticle::query()->latest('updated_at')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new HealthArticle(),
            'action' => route('admin.articles.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request);

        HealthArticle::create($this->buildPayload($data, $request->user()->id, approved: true));

        return redirect()->route('admin.articles.index')->with('status', 'Article created.');
    }

    public function edit(HealthArticle $article): View
    {
        return view('admin.articles.form', [
            'article' => $article,
            'action' => route('admin.articles.update', $article),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, HealthArticle $article): RedirectResponse
    {
        $data = $this->validatePayload($request);
        $article->update($this->buildPayload($data, $request->user()->id, $article, false));

        return redirect()->route('admin.articles.index')->with('status', 'Article updated.');
    }

    public function destroy(HealthArticle $article): RedirectResponse
    {
        AuditLog::create([
            'admin_id' => request()->user()->id,
            'action' => 'delete_article',
            'target_entity_type' => HealthArticle::class,
            'target_entity_id' => (string) $article->getKey(),
            'reason' => 'Removed via admin article manager.',
        ]);

        $article->delete();

        return back()->with('status', 'Article deleted.');
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'summary' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,pending_approval,approved,rejected'],
            'rejection_reason' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function buildPayload(array $data, int $authorId, ?HealthArticle $article = null, bool $approved = false): array
    {
        $slug = Str::slug($data['title']);

        if ($article && $article->slug === $slug) {
            $finalSlug = $article->slug;
        } else {
            $slugQuery = HealthArticle::query()->where('slug', $slug);

            if ($article) {
                $slugQuery->whereKeyNot($article->getKey());
            }

            $finalSlug = $slugQuery->exists() ? $slug.'-'.Str::lower(Str::random(4)) : $slug;
        }

        return [
            'title' => $data['title'],
            'slug' => $finalSlug,
            'category' => $data['category'],
            'summary' => $data['summary'],
            'content' => $data['content'],
            'is_featured' => (bool) ($data['is_featured'] ?? false),
            'status' => $approved ? 'approved' : $data['status'],
            'rejection_reason' => $data['status'] === 'rejected' ? ($data['rejection_reason'] ?? null) : null,
            'published_at' => $data['published_at'] ?? ($approved || $data['status'] === 'approved' ? now() : null),
            'author_id' => $authorId,
        ];
    }
}
