<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleSection;
use App\Traits\ApiResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ArticleSectionsController extends Controller
{
    use ApiResponser, FileUploadTrait;

    public function index(Request $request)
    {
        $query = ArticleSection::query()
            ->when($request->boolean('only_active', false), fn ($q) => $q->where('is_active', true))
            ->orderBy('position')
            ->orderBy('name');

        $sections = $query->paginate($request->integer('per_page', 20));
        return $this->successResponse($sections);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:article_sections,slug'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:1024'],
            'parent_id' => ['nullable', 'exists:article_sections,id'],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Handle cover image upload - move from temp to permanent storage
        $coverImagePath = null;
        if (!empty($data['cover_image'])) {
            $media = json_decode($data['cover_image'], true);
            if (is_array($media) && !empty($media)) {
                $files = $this->moveFile($media, 'media/article-sections', 'article-section');
                $coverImagePath = isset($files[0]) ? $files[0]->path : null;
            } else {
                // If it's already a path string (not JSON), use it as is
                $coverImagePath = $data['cover_image'];
            }
        }

        $section = ArticleSection::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'cover_image' => $coverImagePath,
            'parent_id' => $data['parent_id'] ?? null,
            'position' => $data['position'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return $this->successResponseArray($section, 'Section created');
    }

    public function show(ArticleSection $articleSection)
    {
        $articleSection->load('children');
        return $this->successResponseArray($articleSection);
    }

    public function update(Request $request, ArticleSection $articleSection)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', 'unique:article_sections,slug,' . $articleSection->id],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'max:1024'],
            'parent_id' => ['nullable', 'exists:article_sections,id', 'not_in:' . $articleSection->id],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Handle cover image upload - move from temp to permanent storage
        if (isset($data['cover_image']) && !empty($data['cover_image'])) {
            $media = json_decode($data['cover_image'], true);
            if (is_array($media) && !empty($media)) {
                // New upload - move from temp
                $files = $this->moveFile($media, 'media/article-sections', 'article-section');
                $data['cover_image'] = isset($files[0]) ? $files[0]->path : null;
            }
            // If it's already a path string (not JSON), keep it as is
        }

        $articleSection->update($data);

        return $this->successResponseArray($articleSection, 'Section updated');
    }

    public function destroy(ArticleSection $articleSection)
    {
        $articleSection->delete();
        return $this->successResponseArray(null, 'Section deleted');
    }
}


