<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticlePageController extends Controller
{

    public function index(Request $request, $abbreviation = null)
{
    // ---------------------------------------
    // 1. Load subsections if ?section=ID
    // ---------------------------------------
    $sectionParam = $request->query('section');
    $subsections = collect();

    if (!empty($sectionParam) && is_numeric($sectionParam)) {
        $subsections = ArticleSection::with('parent:id,name')
            ->withCount(['articles' => function($q) {
                $q->where('status', 'published');
            }])
            ->where('parent_id', $sectionParam)
            ->where('is_active', true)
            ->get();
    }

    // ---------------------------------------
    // 2. Load top-level parent sections
    // ---------------------------------------
    $sections = ArticleSection::where('is_active', true)
        ->whereNull('parent_id')
        ->withCount(['children' => function($q) {
            $q->where('is_active', 1);
        }])
        ->orderBy('position')
        ->orderBy('name')
        ->get();

    // ---------------------------------------
    // 3. Featured article only when no filters
    // ---------------------------------------
    $featuredArticle = null;
    if (!$request->filled('section') && !$request->filled('q')) {
        $featuredArticle = Article::with(['section','author'])
            ->where('status', 'published')
            ->whereNotNull('cover_image')
            ->latest('published_at')
            ->first();
    }

    // ---------------------------------------
    // 4. Build article list (section OR search)
    // ---------------------------------------
    $query = Article::with(['section', 'author'])
        ->where('status', 'published')
        ->when($featuredArticle, fn($q) => $q->where('id', '!=', $featuredArticle->id))
        ->when($request->filled('section'), function($q) use ($request) {
            $section = ArticleSection::where('slug', $request->string('section'))->first();
            if ($section) {
                $q->where('section_id', $section->id);
            }
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

    $articles = $query->paginate(10)->withQueryString();

    // ---------------------------------------
    // 5. Determine subsection title for view
    // ---------------------------------------
    $subsection = null;

    // If filter by section, load the section object
    if ($request->filled('section')) {
        $subsection = ArticleSection::where('slug', $request->string('section'))->first();
    }

    // If searching, subsection stays NULL (view shows "Search Results")
    
    // ---------------------------------------
    // 6. If filters OR search, return subsection page
    // ---------------------------------------
    if ($request->filled('q')) {
        return view('web.articles.subsection',
            compact('subsection', 'articles', 'abbreviation'));
    }

    // ---------------------------------------
    // 7. Default homepage
    // ---------------------------------------
    return view('web.articles.index',
        compact('subsections','sections','featuredArticle'));
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

    public function subsection($abbreviation = null, ArticleSection $subsection)
    {
        // Fetch all active articles in this subsection
        $articles = $subsection->articles()->where('status', 'published')->latest()->paginate(10);
        return view('web.articles.subsection', compact('subsection', 'articles', 'abbreviation'));
    }
}


