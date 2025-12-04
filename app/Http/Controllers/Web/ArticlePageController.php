<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Http\Request;

class ArticlePageController extends Controller
{
    public function index(Request $request, $abbreviation = null)
    {
        $sections = ArticleSection::where('is_active', true)
            ->withCount(['articles' => function($q) {
                $q->where('status', 'published');
            }])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        // Get featured article (latest published article if no filters active)
        $featuredArticle = null;
        if (!$request->filled('section') && !$request->filled('q')) {
            $featuredArticle = Article::with(['section','author'])
                ->where('status', 'published')
                ->whereNotNull('cover_image')
                ->latest('published_at')
                ->first();
        }

        $query = Article::with(['section','author'])
            ->where('status', 'published')
            ->when($featuredArticle, fn ($q) => $q->where('id', '!=', $featuredArticle->id))
            ->when($request->filled('section'), function ($q) use ($request) {
                $section = ArticleSection::where('slug', $request->string('section'))->first();
                if ($section) { $q->where('section_id', $section->id); }
            })
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->string('q') . '%';
                $q->where(function ($q2) use ($term) {
                    $q2->where('title', 'like', $term)
                       ->orWhere('summary', 'like', $term);
                });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        $articles = $query->paginate(12)->withQueryString();

        return view('web.articles.index', compact('articles','sections','featuredArticle'));
    }

    public function show(Request $request, $abbreviation = null, string $slug = '')
    {
        $article = Article::with(['section','author'])->where('slug', $slug)->where('status', 'published')->firstOrFail();

        $relatedByAuthor = Article::where('author_id', $article->author_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();

        $relatedByKeywords = collect();
        if (!empty($article->keywords) && is_array($article->keywords)) {
            $excludeIds = $relatedByAuthor->pluck('id')->all();
            $relatedByKeywords = Article::where('id', '!=', $article->id)
                ->where('status', 'published')
                ->when(!empty($excludeIds), fn ($q) => $q->whereNotIn('id', $excludeIds))
                ->where(function ($q) use ($article) {
                    foreach ($article->keywords as $kw) {
                        $q->orWhereJsonContains('keywords', $kw);
                    }
                })
                ->latest('published_at')
                ->take(8)
                ->get();
        }

        return view('web.articles.show', [
            'article' => $article,
            'relatedByAuthor' => $relatedByAuthor,
            'relatedByKeywords' => $relatedByKeywords,
        ]);
    }
}


