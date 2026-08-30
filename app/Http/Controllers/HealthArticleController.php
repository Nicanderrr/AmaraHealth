<?php

namespace App\Http\Controllers;

use App\Models\HealthArticle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HealthArticleController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));

        $baseQuery = HealthArticle::query()->where('status', 'approved');
        $categories = (clone $baseQuery)
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderBy('category')
            ->get();
        $latestPublished = (clone $baseQuery)->latest('published_at')->first()?->published_at;

        $articles = (clone $baseQuery)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->inRandomOrder()
            ->paginate(9)
            ->withQueryString();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'activeCategory' => $category,
            'search' => $search,
            'latestPublished' => $latestPublished,
        ]);
    }

    public function show(HealthArticle $article, Request $request): View
    {
        abort_unless(
            $article->status === 'approved' ||
            ($request->user() && ($request->user()->role === 'admin' || $request->user()->id === $article->author_id)),
            404
        );

        return view('articles.show', compact('article'));
    }
}
