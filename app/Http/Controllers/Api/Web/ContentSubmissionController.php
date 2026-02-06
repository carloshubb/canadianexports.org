<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Mail\ContentSubmittedBySponsorMail;
use App\Traits\FileUploadTrait;
use App\Models\Article;
use App\Models\ArticleSection;
use App\Models\Sponsor;
use App\Models\SponsorVideo;
use App\Models\User;
use App\Rules\YoutubeUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContentSubmissionController extends Controller
{
    use FileUploadTrait;

    public function getArticleSections(Request $request)
    {
        $customer = auth()->guard('customers')->user();
        if (!$customer || $customer->type !== 'sponsor') {
            return response()->json(['status' => 'Error', 'message' => 'Unauthorized'], 403);
        }
        $sections = ArticleSection::where('is_active', true)->orderBy('position')->orderBy('name')->get();
        return response()->json(['status' => 'Success', 'data' => $sections]);
    }

    public function submitArticle(Request $request)
    {
        $customer = auth()->guard('customers')->user();
        if (!$customer || $customer->type !== 'sponsor') {
            return response()->json(['status' => 'Error', 'message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'section_id' => ['required', 'exists:article_sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:1024'],
        ]);

        $slug = Str::slug($data['title']);
        $baseSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        $author = User::first();
        if (!$author) {
            return response()->json(['status' => 'Error', 'message' => 'Configuration error'], 500);
        }

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

        $article = Article::create([
            'section_id' => $data['section_id'],
            'author_id' => $author->id,
            'customer_id' => $customer->id,
            'submitted_by_sponsor' => true,
            'title' => $data['title'],
            'slug' => $slug,
            'summary' => $data['summary'] ?? '',
            'body' => $data['body'],
            'template' => 'standard',
            'cover_image' => $coverImagePath,
            'status' => 'draft',
        ]);

        $this->sendAdminNotification('Article', $article->title, $customer->name ?? $customer->email, $this->getArticleAdminUrl($article->id));

        return response()->json(['status' => 'Success', 'data' => ['id' => $article->id]]);
    }

    public function submitVideo(Request $request)
    {
        $customer = auth()->guard('customers')->user();
        if (!$customer || $customer->type !== 'sponsor') {
            return response()->json(['status' => 'Error', 'message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string', 'max:1000'],
            'youtube_url' => ['required', 'string', new YoutubeUrl],
        ], [
            'youtube_url' => 'Please provide a valid YouTube URL.',
        ]);

        $sponsor = Sponsor::where('customer_id', $customer->id)->first();

        $video = SponsorVideo::create([
            'customer_id' => $customer->id,
            'sponsor_id' => $sponsor?->id,
            'title' => $data['title'],
            'summary' => $data['summary'],
            'youtube_url' => $data['youtube_url'],
            'status' => 'pending',
        ]);

        $this->sendAdminNotification('Video', $video->title, $customer->name ?? $customer->email, $this->getVideoAdminUrl($video->id));

        return response()->json(['status' => 'Success', 'data' => ['id' => $video->id]]);
    }

    private function sendAdminNotification(string $type, string $title, string $submittedBy, string $viewUrl): void
    {
        $general_setting = getSignleGeneralSettingByKey(['admin_email']);
        if (empty($general_setting['admin_email'])) {
            return;
        }
        $emails = array_map('trim', explode(',', $general_setting['admin_email']));
        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->send(new ContentSubmittedBySponsorMail([
                    'type' => $type,
                    'title' => $title,
                    'submitted_by' => $submittedBy,
                    'view_url' => $viewUrl,
                ]));
            }
        }
    }

    private function getArticleAdminUrl(int $id): string
    {
        $base = rtrim(config('app.url'), '/');
        return $base . '/admin/articles/' . $id . '/edit';
    }

    private function getVideoAdminUrl(int $id): string
    {
        $base = rtrim(config('app.url'), '/');
        return $base . '/admin/sponsor-videos/' . $id;
    }
}
