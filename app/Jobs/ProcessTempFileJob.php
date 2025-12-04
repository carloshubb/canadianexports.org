<?php

namespace App\Jobs;

use App\Models\ImportTempFile;
use App\Models\CustomerMedia;
use App\Models\Media;
use App\Models\CustomerGalleryImage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\Exception\NotReadableException;
use Illuminate\Http\Client\RequestException;
use Image;
use Exception;

class ProcessTempFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120; // Timeout for this job (seconds)

    protected $tempFileId;

    public function __construct($tempFileId)
    {
        $this->tempFileId = $tempFileId;
    }

    public function handle()
    {
        
        $tempFile = ImportTempFile::find($this->tempFileId);
        if (!$tempFile) {
            return;
        }

        $data = [
            'url' => $tempFile->logo,
            'customer_media_id' => $tempFile->customer_media_id,
            'temp_file_id' => $tempFile->id,
        ];

        $isMediaExists = Media::where('external_image_path', $data['url'])->whereCustomerMediaId($data['customer_media_id'])->exists();
        if ($isMediaExists) {
            return;
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

        ImportTempFile::where('id', $tempFile->id)->update(['created_chunk' => '1']);
        
        
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


    public function resizeFile($type, $fileName, $destinationFolder, $tempFile)
    {
        try {
            $general_setting = getSignleGeneralSettingByKey(['thumbnail_image_width', 'thumbnail_image_height']);

            if (isset($general_setting, $general_setting['thumbnail_image_width'], $general_setting['thumbnail_image_height'])) {
                $img = Image::make($fileName);
                $imgWidth = $img->width();
                $imgHeight = $img->height();

                if ($imgWidth >= $imgHeight) {
                    if ($imgWidth > $general_setting['thumbnail_image_width']) {
                        $img->resize($general_setting['thumbnail_image_width'], $general_setting['thumbnail_image_height'], function ($const) {
                            $const->aspectRatio();
                        })->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                    } else {
                        $img->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                    }
                } else if ($imgHeight > $imgWidth) {
                    if ($imgHeight > $general_setting['thumbnail_image_height']) {
                        $img->resize($general_setting['thumbnail_image_height'], $general_setting['thumbnail_image_width'], function ($const) {
                            $const->aspectRatio();
                        })->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                    } else {
                        $img->save(public_path($destinationFolder) . '/thumbnail-' . basename($tempFile));
                    }
                }
            }

            $general_setting = getSignleGeneralSettingByKey(['medium_image_width', 'medium_image_height']);
            if (isset($general_setting, $general_setting['medium_image_width'], $general_setting['medium_image_height'])) {
                $img = Image::make($fileName);
                $imgWidth = $img->width();
                $imgHeight = $img->height();

                if ($imgWidth >= $imgHeight) {
                    if ($imgWidth > $general_setting['medium_image_width']) {
                        $img->resize($general_setting['medium_image_width'], $general_setting['medium_image_height'], function ($const) {
                            $const->aspectRatio();
                        })->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                    } else {
                        $img->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                    }
                } else if ($imgHeight > $imgWidth) {
                    if ($imgHeight > $general_setting['medium_image_height']) {
                        $img->resize($general_setting['medium_image_height'], $general_setting['medium_image_width'], function ($const) {
                            $const->aspectRatio();
                        })->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                    } else {
                        $img->save(public_path($destinationFolder) . '/medium-' . basename($tempFile));
                    }
                }
            }

            $general_setting = getSignleGeneralSettingByKey(['large_image_width', 'large_image_height']);
            if (isset($general_setting, $general_setting['large_image_width'], $general_setting['large_image_height'])) {
                $img = Image::make($fileName);
                $imgWidth = $img->width();
                $imgHeight = $img->height();

                if ($imgWidth >= $imgHeight) {
                    if ($imgWidth > $general_setting['large_image_width']) {
                        $img->resize($general_setting['large_image_width'], $general_setting['large_image_height'], function ($const) {
                            $const->aspectRatio();
                        })->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                    } else {
                        $img->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                    }
                } else if ($imgHeight > $imgWidth) {
                    if ($imgHeight > $general_setting['large_image_height']) {
                        $img->resize($general_setting['large_image_height'], $general_setting['large_image_width'], function ($const) {
                            $const->aspectRatio();
                        })->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                    } else {
                        $img->save(public_path($destinationFolder) . '/large-' . basename($tempFile));
                    }
                }
            }
        } catch (NotReadableException $e) {
            // Handle the error - log it, notify, etc.
            \Log::error("The file at $fileName could not be read as a valid image. Error: " . $e->getMessage());
            return;
        }
    }
}
