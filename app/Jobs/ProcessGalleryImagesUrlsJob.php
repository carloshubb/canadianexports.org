<?php

namespace App\Jobs;

use App\Models\CustomerGalleryImage;
use App\Models\ImportTempFile;
use App\Models\Media;
use App\Traits\FileUploadTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessGalleryImagesUrlsJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use FileUploadTrait;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->data['urls'] as $url) {
            if (isset($url) && $url != '' && filter_var($url, FILTER_VALIDATE_URL)) {
                try {
                    $response = Http::timeout(10)->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'
                    ])->get($url);

                    if ($response->successful()) {
                        $logoContent = $response->body();
                        $path = parse_url($url, PHP_URL_PATH);
                        $extension = pathinfo($path, PATHINFO_EXTENSION);
                        $storagePath = public_path('media/customers');

                        if (!File::exists($storagePath)) {
                            File::makeDirectory($storagePath, 0755, true);
                        }

                        $currentTime = time();
                        $fileName = $currentTime . '-' . basename($url);
                        $filePath = $storagePath . '/' . $fileName;
                        file_put_contents($filePath, $logoContent);

                        $media = Media::create([
                            'path' => 'media/customers/' . $fileName,
                            'type' => 'profile_gallery_images',
                            'extension' => $extension,
                            'thumbnail_image' => 'media/customers/' . 'thumbnail-' . basename($fileName),
                            'medium_image' => 'media/customers/' . 'medium-' . basename($fileName),
                            'large_image' => 'media/customers/' . 'large-' . basename($fileName),
                        ]);

                        $this->resizeFile('profile_gallery_images', $filePath, 'media/customers', $fileName);
                        CustomerGalleryImage::create([
                            'customer_media_id' => $this->data['customer_media_id'],
                            'media_id' => $media->id,
                        ]);
                    } else {
                        Log::error('Failed to fetch image from: ' . $url);
                    }
                } catch (RequestException $e) {
                    Log::error('Error fetching image from: ' . $url . '. Error: ' . $e->getMessage());
                }
            }
        }
        ImportTempFile::whereId($this->data['temp_file_id'])->update([
            'image1' => null,
            'image2' => null,
            'image3' => null,
            'image4' => null,
        ]);
    }
}
