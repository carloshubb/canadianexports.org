<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\ApiResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArticlesController extends Controller
{
    use ApiResponser, FileUploadTrait;

    public function index(Request $request)
    {
        $query = Article::query()
            ->with(['section', 'author'])
            ->when($request->filled('section_id'), fn ($q) => $q->where('section_id', $request->integer('section_id')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->string('q') . '%';
                $q->where(function ($q2) use ($term) {
                    $q2->where('title', 'like', $term)
                       ->orWhere('summary', 'like', $term);
                });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        $articles = $query->paginate($request->integer('per_page', 20));
        return $this->successResponse($articles);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'section_id' => ['required', 'exists:article_sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:articles,slug'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'template' => ['nullable', 'string', Rule::in(['standard','image_left','image_right','media_bottom'])],
            'cover_image' => ['nullable', 'string', 'max:1024'],
            'video_url' => ['nullable', 'string', 'max:1024'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:50'],
            'status' => ['nullable', 'string', Rule::in(['draft','published'])],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ]);

        // Handle cover image upload - move from temp to permanent storage
        $coverImagePath = null;
        if (!empty($data['cover_image'])) {
            $media = json_decode($data['cover_image'], true);
            if (is_array($media) && !empty($media)) {
                $files = $this->moveFile($media, 'media/articles', 'article');
                $coverImagePath = isset($files[0]) ? $files[0]->path : null;
            } else {
                $coverImagePath = $data['cover_image'];
            }
        }

        $article = Article::create(array_merge($data, [
            'author_id' => $request->user()->id,
            'template' => $data['template'] ?? 'standard',
            'status' => $data['status'] ?? 'draft',
            'cover_image' => $coverImagePath,
        ]));

        return $this->successResponseArray($article->load(['section','author']), 'Article created');
    }

    public function show(Article $article)
    {
        $article->load(['section','author']);
        return $this->successResponseArray($article);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'section_id' => ['sometimes', 'required', 'exists:article_sections,id'],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:articles,slug,' . $article->id],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['sometimes', 'required', 'string'],
            'template' => ['nullable', 'string', Rule::in(['standard','image_left','image_right','media_bottom'])],
            'cover_image' => ['nullable', 'string', 'max:1024'],
            'video_url' => ['nullable', 'string', 'max:1024'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:50'],
            'status' => ['nullable', 'string', Rule::in(['draft','published'])],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ]);

        // Handle cover image upload - move from temp to permanent storage
        if (isset($data['cover_image']) && !empty($data['cover_image'])) {
            $media = json_decode($data['cover_image'], true);
            if (is_array($media) && !empty($media)) {
                $files = $this->moveFile($media, 'media/articles', 'article');
                $data['cover_image'] = isset($files[0]) ? $files[0]->path : null;
            }
        }

        $article->update($data);

        return $this->successResponseArray($article->load(['section','author']), 'Article updated');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return $this->successResponseArray(null, 'Article deleted');
    }
}


