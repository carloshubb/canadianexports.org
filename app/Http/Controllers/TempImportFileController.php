<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerGalleryImage;
use App\Models\CustomerMedia;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\ImportTempFile;
use App\Models\Media;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TempImportFileController extends Controller
{
    use FileUploadTrait;

    public function index(Request $request)
    {

        ImportTempFile::where(function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->whereNull('logo')
                    ->orWhere('logo', '0');
            })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image1')
                        ->orWhere('image1', '0');
                })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image2')
                        ->orWhere('image2', '0');
                })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image3')
                        ->orWhere('image3', '0');
                })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image4')
                        ->orWhere('image4', '0');
                });
        })->delete();


        ImportTempFile::whereNotNull('logo')
            ->select('id', 'customer_media_id', 'logo')
            ->chunk(100, function ($tempFiles) {
                foreach ($tempFiles as $tempFile) {
                    $data = [
                        'url' => $tempFile->logo,
                        'customer_media_id' => $tempFile->customer_media_id,
                        'temp_file_id' => $tempFile->id,
                    ];

                    $isMediaExists = Media::where('external_image_path', $data['url'])->whereCustomerMediaId($data['customer_media_id'])->exists();
                    if ($isMediaExists) {
                        continue;
                    }

                    if (isset($data['url']) && $data['url'] != '' && filter_var($data['url'], FILTER_VALIDATE_URL)) {
                        try {
                            $headers = get_headers($data['url'], 1);

                            // Check if the URL exists and the content type is an image
                            if ($headers && strpos($headers[0], '200') !== false) {
                                $contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : '';

                                if (strpos($contentType, 'image/') === 0) {
                                    $response = Http::timeout(10)->get($data['url']);

                                    if ($response->successful()) {
                                        $logoContent = $response->body();
                                        $path = parse_url($data['url'], PHP_URL_PATH);
                                        $extension = pathinfo($path, PATHINFO_EXTENSION);
                                        $storagePath = public_path('media/customers');

                                        if (!File::exists($storagePath)) {
                                            File::makeDirectory($storagePath, 0755, true);
                                        }

                                        $currentTime = time();
                                        $fileName = $currentTime . '-' . basename($data['url']);
                                        $filePath = $storagePath . '/' . $fileName;

                                        // Store the logo content in a local file
                                        file_put_contents($filePath, $logoContent);

                                        DB::beginTransaction();
                                        // Save file information in the media table
                                        $media = Media::create([
                                            'path' => 'media/customers/' . $fileName,
                                            'type' => 'profile_logo',
                                            'extension' => $extension,
                                            'thumbnail_image' => 'media/customers/' . 'thumbnail-' . basename($fileName),
                                            'medium_image' => 'media/customers/' . 'medium-' . basename($fileName),
                                            'large_image' => 'media/customers/' . 'large-' . basename($fileName),
                                            'external_image_path' => $data['url'] ?? null,
                                            'customer_media_id' => $data['customer_media_id'] ?? null,
                                        ]);

                                        // Call the resize function to generate different sizes
                                        $this->resizeFile('profile_logo', $filePath, 'media/customers', $fileName);

                                        CustomerMedia::whereId($data['customer_media_id'])->update([
                                            "logo" => $media->id ?? null,
                                        ]);
                                        DB::commit();
                                    } else {
                                        Log::error('Failed to fetch image from: ' . $data['url']);
                                    }
                                } else {
                                    Log::error('The URL is not an image: ' . $data['url']);
                                }
                            } else {
                                Log::error('The URL does not exist: ' . $data['url']);
                            }
                        } catch (RequestException $e) {
                            Log::error('Error fetching image from: ' . $data['url'] . '. Error: ' . $e->getMessage());
                        }

                        ImportTempFile::whereId($data['temp_file_id'])->update([
                            'logo' => null,
                        ]);
                    }
                }
            });

        ImportTempFile::select('id', 'customer_media_id', 'image1', 'image2', 'image3', 'image4')
            ->chunk(100, function ($tempFiles) {
                foreach ($tempFiles as $tempFile) {
                    $urls = [];
                    if (isset($tempFile->image1)) {
                        $this->uploadImage($tempFile->image1, $tempFile->customer_media_id, $tempFile->id, 'image1');
                    }
                    if (isset($tempFile->image2)) {
                        $this->uploadImage($tempFile->image2, $tempFile->customer_media_id, $tempFile->id, 'image2');
                    }
                    if (isset($tempFile->image3)) {
                        $this->uploadImage($tempFile->image3, $tempFile->customer_media_id, $tempFile->id, 'image3');
                    }
                    if (isset($tempFile->image4)) {
                        $this->uploadImage($tempFile->image4, $tempFile->customer_media_id, $tempFile->id, 'image4');
                    }
                }
            });

        ImportTempFile::where(function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->whereNull('logo')
                    ->orWhere('logo', '0');
            })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image1')
                        ->orWhere('image1', '0');
                })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image2')
                        ->orWhere('image2', '0');
                })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image3')
                        ->orWhere('image3', '0');
                })
                ->where(function ($subQuery) {
                    $subQuery->whereNull('image4')
                        ->orWhere('image4', '0');
                });
        })->delete();

        return 'Done';
    }

    protected function uploadImage($url, $customerMediaId, $tempFileId, $name)
    {
        if (isset($url) && $url != '' && filter_var($url, FILTER_VALIDATE_URL)) {
            try {
                $headers = get_headers($url, 1);

                $isMediaExists = Media::where('external_image_path', $url)->whereCustomerMediaId($customerMediaId)->exists();
                // If media already exists, return early
                if ($isMediaExists) {
                    Log::info('Media already exists for URL: ' . $url);
                    return; // Exit the function early if the media already exists
                }

                // Check if the URL exists and the content type is an image
                if ($headers && strpos($headers[0], '200') !== false) {
                    $contentType = isset($headers['Content-Type']) ? $headers['Content-Type'] : '';

                    if (strpos($contentType, 'image/') === 0) {
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

                            DB::beginTransaction();
                            $media = Media::create([
                                'path' => 'media/customers/' . $fileName,
                                'type' => 'profile_gallery_images',
                                'extension' => $extension,
                                'thumbnail_image' => 'media/customers/' . 'thumbnail-' . basename($fileName),
                                'medium_image' => 'media/customers/' . 'medium-' . basename($fileName),
                                'large_image' => 'media/customers/' . 'large-' . basename($fileName),
                                'external_image_path' => $url ?? null,
                                'customer_media_id' => $customerMediaId ?? null,
                            ]);

                            $this->resizeFile('profile_gallery_images', $filePath, 'media/customers', $fileName);


                            CustomerGalleryImage::create([
                                'customer_media_id' => $customerMediaId,
                                'media_id' => $media->id,
                            ]);

                            ImportTempFile::whereId($tempFileId)->update([
                                $name => null,
                            ]);
                            DB::commit();
                        } else {
                            Log::error('Failed to fetch image from: ' . $url);
                        }
                    } else {
                        Log::error('The URL is not an image: ' . $url);
                    }
                } else {
                    Log::error('The URL does not exist: ' . $url);
                }
            } catch (RequestException $e) {
                Log::error('Error fetching image from: ' . $url . '. Error: ' . $e->getMessage());
            }
        }
    }
}
