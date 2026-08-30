<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\HealthArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HealthArticleController extends Controller
{
    public function index(Request $request): View
    {
        return view('professional.articles.index', [
            'articles' => HealthArticle::query()->where('author_id', $request->user()->id)->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('professional.articles.form', [
            'article' => new HealthArticle(),
            'action' => route('professional.articles.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'summary' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
        ]);

        HealthArticle::create([
            'author_id' => $request->user()->id,
            'author_title' => $request->user()->professional_title,
            'author_display_name' => $request->user()->display_name ?: $request->user()->name,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(4)),
            'category' => $data['category'],
            'summary' => $data['summary'],
            'content' => $data['content'],
            'status' => 'pending_approval',
            'published_at' => null,
        ]);

        return redirect()->route('professional.articles.index')->with('status', 'Article submitted for approval.');
    }
}
