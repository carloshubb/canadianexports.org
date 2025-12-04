<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request, $abbreviation = null)
    {
        $query = Article::query()
            ->with(['section', 'author'])
            ->where('status', 'published')
            ->when($request->filled('section'), function ($q) use ($request) {
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

        return response()->json([
            'status' => 'Success',
            'data' => $query->paginate($request->integer('per_page', 12)),
        ]);
    }

    public function show(Request $request, $abbreviation = null, string $slug = '')
    {
        $article = Article::with(['section', 'author'])->where('slug', $slug)->where('status', 'published')->firstOrFail();

        // Related: first by same author, then by keyword overlap
        $relatedByAuthor = Article::where('author_id', $article->author_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(4)
            ->get();

        $relatedByKeywords = collect();
        if (!empty($article->keywords) && is_array($article->keywords)) {
            $relatedByKeywords = Article::where('id', '!=', $article->id)
                ->where('status', 'published')
                ->where(function ($q) use ($article) {
                    foreach ($article->keywords as $kw) {
                        $q->orWhereJsonContains('keywords', $kw);
                    }
                })
                ->latest('published_at')
                ->take(8)
                ->get();
        }

        return response()->json([
            'status' => 'Success',
            'data' => [
                'article' => $article,
                'related' => [
                    'by_author' => $relatedByAuthor,
                    'by_keywords' => $relatedByKeywords,
                ],
            ],
        ]);
    }
}


