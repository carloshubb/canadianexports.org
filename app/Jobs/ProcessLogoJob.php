<?php

namespace App\Jobs;

use App\Models\CustomerMedia;
use App\Models\ImportTempFile;
use App\Models\Media;
use App\Traits\FileUploadTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessLogoJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use FileUploadTrait;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param string $data
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
        if (isset($this->data['url']) && $this->data['url'] != '' && filter_var($this->data['url'], FILTER_VALIDATE_URL)) {
            try {
                $response = Http::timeout(10)->get($this->data['url']);

                if ($response->successful()) {
                    $logoContent = $response->body();
                    $path = parse_url($this->data['url'], PHP_URL_PATH);
                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                    $storagePath = public_path('media/customers');

                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath, 0755, true);
                    }

                    $currentTime = time();
                    $fileName = $currentTime . '-' . basename($this->data['url']);
                    $filePath = $storagePath . '/' . $fileName;

                    // Store the logo content in a local file
                    file_put_contents($filePath, $logoContent);

                    // Save file information in the media table
                    $media = Media::create([
                        'path' => 'media/customers/' . $fileName,
                        'type' => 'profile_logo',
                        'extension' => $extension,
                        'thumbnail_image' => 'media/customers/' . 'thumbnail-' . basename($fileName),
                        'medium_image' => 'media/customers/' . 'medium-' . basename($fileName),
                        'large_image' => 'media/customers/' . 'large-' . basename($fileName),
                    ]);

                    // Call the resize function to generate different sizes
                    $this->resizeFile('profile_logo', $filePath, 'media/customers', $fileName);

                    CustomerMedia::whereId($this->data['customer_media_id'])->update([
                        "logo" => $media->id ?? null,
                    ]);
                } else {
                    Log::error('Failed to fetch image from: ' . $this->data['url']);
                }
            } catch (RequestException $e) {
                Log::error('Error fetching image from: ' . $this->data['url'] . '. Error: ' . $e->getMessage());
            }

            ImportTempFile::whereId($this->data['temp_file_id'])->update([
                'logo' => null,
            ]);
        }
    }
}
