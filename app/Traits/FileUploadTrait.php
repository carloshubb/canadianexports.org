<?php

namespace App\Traits;

use App\Models\Media;
use App\Models\TemporaryMedia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Intervention\Image\Exception\NotReadableException;

trait FileUploadTrait
{
    protected $uploadPath = 'media';
    public $folderName;
    public $rule = 'image|max:2000';

    private function normalizeTempPath($path)
    {
        if (empty($path)) {
            return '';
        }
        // If a full URL is provided, extract the path only
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $parsed = parse_url($path, PHP_URL_PATH);
            if (is_string($parsed)) {
                $path = $parsed;
            }
        }
        // Trim leading slashes
        $path = ltrim($path, '/\\');
        // If path starts with 'storage/', convert to public disk relative path
        if (strpos($path, 'storage/') === 0) {
            $path = substr($path, strlen('storage/'));
        }
        // Normalize directory separators
        return str_replace('\\', '/', $path);
    }

    private function createMediaFolder($folderName = null): bool
    {
        $targetFolder = $folderName ?: $this->folderName;
        
        // For temp folders, include the full path with 'media/'
        if (strpos($targetFolder, 'temp/') === 0 || strpos($targetFolder, 'temp\\') === 0) {
            $targetFolder = $this->uploadPath . '/' . $targetFolder;
        }
        
        $attachmentPath = getWebPublicPath($targetFolder);
        
        if (!file_exists($attachmentPath)) {
            mkdir($attachmentPath, 0755, true);
            return true;
        }

        return false;
    }

    /**
     * For handle validation file action
     *
     * @param $file
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFileAction($file)
    {

        $rules = array('fileupload' => $this->rule);
        $file  = array('fileupload' => $file);

        $fileValidator = Validator::make($file, $rules);

        if ($fileValidator->fails()) {

            $messages = $fileValidator->messages();

            return redirect()->back()->withInput(request()->all())
                ->withErrors($messages);
        }
    }

    /**
     * For Handle validation file
     *
     * @param $files
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFile($files)
    {

        if (is_array($files)) {
            foreach ($files as $file) {
                return $this->validateFileAction($file);
            }
        }

        return $this->validateFileAction($files);
    }

    /**
     * For Handle Put File
     *
     * @param $file
     * @return bool|string
     */
    private function putFile($file)
    {
        $fileName = preg_replace('/\s+/', '_', time() . ' ' . $file->getClientOriginalName());
        $path     = $this->uploadPath . '/' . $this->folderName . '/';

        // For temp media, ALWAYS save directly to web-accessible path (Hostinger compatibility)
        // Check if folderName contains "temp" (more flexible check)
        $isTempMedia = (
            strpos($this->folderName, 'temp/') === 0 || 
            strpos($this->folderName, 'temp\\') === 0 ||
            strpos($this->folderName, 'temp') === 0
        );
        
        if ($isTempMedia) {
            // Get the full directory path (remove trailing slash for getWebPublicPath)
            $pathForWeb = rtrim($path, '/\\');
            $fullDirPath = getWebPublicPath($pathForWeb);
            
            // Log for debugging
            \Log::info('putFile: Saving temp file', [
                'folderName' => $this->folderName,
                'isTempMedia' => $isTempMedia,
                'path' => $path,
                'pathForWeb' => $pathForWeb,
                'fullDirPath' => $fullDirPath,
                'fileName' => $fileName,
                'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'not set',
                'public_path' => public_path(),
                'web_public_path_test' => getWebPublicPath('media/temp/test'),
            ]);
            
            // Ensure directory exists
            if (!file_exists($fullDirPath)) {
                $created = @mkdir($fullDirPath, 0755, true);
                \Log::info('putFile: Created directory', [
                    'fullDirPath' => $fullDirPath,
                    'created' => $created,
                    'exists_after' => file_exists($fullDirPath),
                    'is_writable' => is_writable(dirname($fullDirPath)),
                ]);
            }
            
            // Full file path including filename
            $fullFilePath = $fullDirPath . DIRECTORY_SEPARATOR . $fileName;
            
            // Move file to web-accessible location
            try {
                $moved = $file->move($fullDirPath, $fileName);
                if ($moved) {
                    \Log::info('putFile: File moved successfully', [
                        'fullFilePath' => $fullFilePath,
                        'exists' => file_exists($fullFilePath),
                        'readable' => is_readable($fullFilePath),
                    ]);
                    // Return relative path (media/temp/.../filename) for database storage
                    return $path . $fileName;
                } else {
                    \Log::error('putFile: File move failed - move() returned false', [
                        'fullDirPath' => $fullDirPath,
                        'fileName' => $fileName,
                        'dir_exists' => file_exists($fullDirPath),
                        'dir_writable' => is_writable($fullDirPath),
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('putFile: Exception during file move', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'fullDirPath' => $fullDirPath,
                    'fileName' => $fileName,
                ]);
            }
            
            return false;
        }

        // For non-temp files, use Storage (works with symlink on local)
        if (Storage::putFileAs('public/' . $path, $file, $fileName)) {
            return $path . $fileName;
        }

        return false;
    }

    /**
     * For Handle Save File Process
     *
     * @param $files
     * @return array
     */
    public function saveFiles($files, $folderName)
    {
        $data = [];
        $this->folderName = $folderName;

        if ($files != null) {

            $this->validateFile($files);

            $this->createMediaFolder();

            if (is_array($files)) {

                foreach ($files as $file) {
                    $data[] = $this->putFile($file);
                }
            } else {

                $data[] = $this->putFile($files);
            }
        }

        return $data;
    }

    public function removeFile($files)
    {
        if (is_array($files)) {
            foreach ($files as $file) {
                // Normalize path
                $normalizedFile = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file);
                
                // Check if it's a temp file (saved to web-accessible path on Hostinger)
                if (strpos($normalizedFile, 'media' . DIRECTORY_SEPARATOR . 'temp') === 0) {
                    // Try web-accessible path first (Hostinger)
                    $filePath = getWebPublicPath($normalizedFile);
                    if (!file_exists($filePath)) {
                        // Fallback to storage path (local)
                        $filePath = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . $normalizedFile;
                    }
                } else {
                    // Regular file in storage
                    $filePath = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . $normalizedFile;
                }
                
                if (file_exists($filePath)) {
                    unlink($filePath);
                    $url = pathinfo($file, PATHINFO_DIRNAME);
                    $url_var = explode('/', $url);
                    $folderName = end($url_var);
                    
                    // Try both paths for temp directory cleanup
                    $tempDir = getWebPublicPath('media/temp/' . $folderName);
                    if (!is_dir($tempDir)) {
                        $tempDir = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . $folderName;
                    }
                    
                    if (is_dir($tempDir) && count(scandir($tempDir)) <= 2) {
                        rmdir($tempDir);
                    }
                }
            }
            return 1;
        } else {
            // Normalize path
            $normalizedFile = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $files);
            
            // Check if it's a temp file (saved to web-accessible path on Hostinger)
            if (strpos($normalizedFile, 'media' . DIRECTORY_SEPARATOR . 'temp') === 0) {
                // Try web-accessible path first (Hostinger)
                $filePath = getWebPublicPath($normalizedFile);
                if (!file_exists($filePath)) {
                    // Fallback to storage path (local)
                    $filePath = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . $normalizedFile;
                }
            } else {
                // Regular file in storage
                $filePath = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . $normalizedFile;
            }
            
            if (file_exists($filePath)) {
                unlink($filePath);
                $url = pathinfo($files, PATHINFO_DIRNAME);
                $url_var = explode('/', $url);
                $folderName = end($url_var);
                
                // Try both paths for temp directory cleanup
                $tempDir = getWebPublicPath('media/temp/' . $folderName);
                if (!is_dir($tempDir)) {
                    $tempDir = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . $folderName;
                }
                
                if (is_dir($tempDir) && count(scandir($tempDir)) <= 2) {
                    rmdir($tempDir);
                }
            }
            return 1;
        }
        return 0;
    }


    public function moveFile($tempFiles, $destinationFolder, $type)
    {
        $media = null;
        $this->createMediaFolder($destinationFolder);
        
        if (is_array($tempFiles)) {
            foreach ($tempFiles as $key => $tempFile) {
                if (empty($tempFile)) {
                    Log::error("moveFile: tempFile is empty, skipping.");
                    continue;
                }
                // Normalize any absolute URL or '/storage/...' paths from client
                $normalizedTemp = $this->normalizeTempPath($tempFile);
                
                Log::info("moveFile: Processing temp file", [
                    'original' => $tempFile,
                    'normalized' => $normalizedTemp
                ]);
                
                // Ensure consistent directory separators
                $normalizedTemp = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $normalizedTemp);
                
                // The path comes as "media/temp/xxx/file.jpg" and is stored in storage/app/public/
                // Normalize the storage root path too (fix mixed separators)
                $storageRoot = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, config('filesystems.disks.public.root'));
                $sourcePath = $storageRoot . DIRECTORY_SEPARATOR . $normalizedTemp;
                if (!file_exists($sourcePath) || !is_file($sourcePath)) {
                    // Try direct public path (e.g., public/media/temp/...)
                    $altSourcePath = getWebPublicPath($normalizedTemp);
                    if (file_exists($altSourcePath) && is_file($altSourcePath)) {
                        $sourcePath = $altSourcePath;
                        Log::info("moveFile: Found file at alternative path (public): {$altSourcePath}");
                    } else {
                        // Try via public/storage symlink (e.g., public/storage/media/temp/...)
                        $symlinkSourcePath = getWebPublicPath('storage' . DIRECTORY_SEPARATOR . $normalizedTemp);
                        if (file_exists($symlinkSourcePath) && is_file($symlinkSourcePath)) {
                            $sourcePath = $symlinkSourcePath;
                            Log::info("moveFile: Found file at symlink path: {$symlinkSourcePath}");
                        } else {
                            Log::error("moveFile: File not found at any path. Tried: {$sourcePath}, {$altSourcePath}, {$symlinkSourcePath}");
                        }
                    }
                }
                $destinationPath = getWebPublicPath($destinationFolder . DIRECTORY_SEPARATOR . basename($tempFile));
                
                if (file_exists($sourcePath) && is_file($sourcePath)) {
                    // Ensure destination directory exists
                    $destinationDir = dirname($destinationPath);
                    if (!file_exists($destinationDir)) {
                        mkdir($destinationDir, 0755, true);
                    }
                    
                    try {
                        File::move($sourcePath, $destinationPath);
                    } catch (\Exception $e) {
                        Log::error("moveFile: Failed to move file from $sourcePath to $destinationPath. Error: " . $e->getMessage());
                        continue;
                    }

                    $media[] = Media::create([
                        'path' => $destinationFolder . '/' . basename($tempFile),
                        'type' => $type,
                        'thumbnail_image' => $destinationFolder . '/' . 'thumbnail-' . basename($tempFile),
                        'medium_image' => $destinationFolder . '/' . 'medium-' . basename($tempFile),
                        'large_image' => $destinationFolder . '/' . 'large-' . basename($tempFile),
                        'extension' => pathinfo($tempFile, PATHINFO_EXTENSION),
                    ]);
                    TemporaryMedia::wherePath($tempFile)->delete();
                    $this->resizeFile($type, $destinationFolder . '/' . basename($tempFile), $destinationFolder, basename($tempFile));
                } else {
                    Log::error("moveFile: Source file does not exist or is not a file: $sourcePath");
                }
            }
        } else {
            if (empty($tempFiles)) {
                Log::error("moveFile: tempFiles is empty, skipping.");
                return $media;
            }
            // Normalize any absolute URL or '/storage/...' paths from client
            $normalizedTemp = $this->normalizeTempPath($tempFiles);
            // Resolve source path from storage/app/public first, then fall back to public paths if needed
            $sourcePath = config('filesystems.disks.public.root') . DIRECTORY_SEPARATOR . $normalizedTemp;
            if (!file_exists($sourcePath) || !is_file($sourcePath)) {
                // Try direct public path (e.g., public/media/temp/...)
                $altSourcePath = getWebPublicPath($normalizedTemp);
                if (file_exists($altSourcePath) && is_file($altSourcePath)) {
                    $sourcePath = $altSourcePath;
                } else {
                    // Try via public/storage symlink (e.g., public/storage/media/temp/...)
                    $symlinkSourcePath = getWebPublicPath('storage' . DIRECTORY_SEPARATOR . $normalizedTemp);
                    if (file_exists($symlinkSourcePath) && is_file($symlinkSourcePath)) {
                        $sourcePath = $symlinkSourcePath;
                    }
                }
            }
            $destinationPath = getWebPublicPath($destinationFolder . DIRECTORY_SEPARATOR . basename($tempFiles));
            
            if (file_exists($sourcePath) && is_file($sourcePath)) {
                // Ensure destination directory exists
                $destinationDir = dirname($destinationPath);
                if (!file_exists($destinationDir)) {
                    mkdir($destinationDir, 0755, true);
                }
                try {
                    File::move($sourcePath, $destinationPath);
                } catch (\Exception $e) {
                    Log::error("moveFile: Failed to move file from $sourcePath to $destinationPath. Error: " . $e->getMessage());
                    return $media;
                }
                
                $media[] = Media::create([
                    'path' => $destinationFolder . '/' . basename($tempFiles),
                    'type' => $type,
                    'thumbnail_image' => $destinationFolder . '/' . 'thumbnail-' . basename($tempFiles),
                    'medium_image' => $destinationFolder . '/' . 'medium-' . basename($tempFiles),
                    'large_image' => $destinationFolder . '/' . 'large-' . basename($tempFiles),
                    'extension' => pathinfo($tempFiles, PATHINFO_EXTENSION),
                ]);
                TemporaryMedia::wherePath($tempFiles)->delete();
                $this->resizeFile($type, $destinationFolder . '/' . basename($tempFiles), $destinationFolder, basename($tempFiles));
            } else {
                Log::error("moveFile: Source file does not exist or is not a file: $sourcePath");
            }
        }
        return $media;
    }
    public function resizeFile($type, $fileName, $destinationFolder, $tempFile)
    {
        // Increase memory limit for image processing
        $currentMemoryLimit = ini_get('memory_limit');
        $memoryLimitBytes = $this->convertToBytes($currentMemoryLimit);
        if ($memoryLimitBytes < 256 * 1024 * 1024) {
            @ini_set('memory_limit', '256M');
        }

        try {
            $fullPath = getWebPublicPath($fileName);
            if (!file_exists($fullPath)) {
                Log::error("File not found for resizing: $fullPath");
                return;
            }

            $general_setting = getSignleGeneralSettingByKey(['thumbnail_image_width', 'thumbnail_image_height']);

            if (isset($general_setting, $general_setting['thumbnail_image_width'], $general_setting['thumbnail_image_height'])) {
                $img = Image::make($fullPath);
                $imgWidth = $img->width();
                $imgHeight = $img->height();

                if ($imgWidth >= $imgHeight) {
                    if ($imgWidth > $general_setting['thumbnail_image_width']) {
                        $img->resize($general_setting['thumbnail_image_width'], $general_setting['thumbnail_image_height'], function ($const) {
                            $const->aspectRatio();
                        })->save(getWebPublicPath($destinationFolder . '/thumbnail-' . basename($tempFile)));
                    } else {
                        $img->save(getWebPublicPath($destinationFolder . '/thumbnail-' . basename($tempFile)));
                    }
                } else if ($imgHeight > $imgWidth) {
                    if ($imgHeight > $general_setting['thumbnail_image_height']) {
                        $img->resize($general_setting['thumbnail_image_height'], $general_setting['thumbnail_image_width'], function ($const) {
                            $const->aspectRatio();
                        })->save(getWebPublicPath($destinationFolder . '/thumbnail-' . basename($tempFile)));
                    } else {
                        $img->save(getWebPublicPath($destinationFolder . '/thumbnail-' . basename($tempFile)));
                    }
                }
                // Destroy image object to free memory
                $img->destroy();
                unset($img);
            }

            $general_setting = getSignleGeneralSettingByKey(['medium_image_width', 'medium_image_height']);
            if (isset($general_setting, $general_setting['medium_image_width'], $general_setting['medium_image_height'])) {
                $img = Image::make($fullPath);
                $imgWidth = $img->width();
                $imgHeight = $img->height();

                if ($imgWidth >= $imgHeight) {
                    if ($imgWidth > $general_setting['medium_image_width']) {
                        $img->resize($general_setting['medium_image_width'], $general_setting['medium_image_height'], function ($const) {
                            $const->aspectRatio();
                        })->save(getWebPublicPath($destinationFolder . '/medium-' . basename($tempFile)));
                    } else {
                        $img->save(getWebPublicPath($destinationFolder . '/medium-' . basename($tempFile)));
                    }
                } else if ($imgHeight > $imgWidth) {
                    if ($imgHeight > $general_setting['medium_image_height']) {
                        $img->resize($general_setting['medium_image_height'], $general_setting['medium_image_width'], function ($const) {
                            $const->aspectRatio();
                        })->save(getWebPublicPath($destinationFolder . '/medium-' . basename($tempFile)));
                    } else {
                        $img->save(getWebPublicPath($destinationFolder . '/medium-' . basename($tempFile)));
                    }
                }
                // Destroy image object to free memory
                $img->destroy();
                unset($img);
            }

            $general_setting = getSignleGeneralSettingByKey(['large_image_width', 'large_image_height']);
            if (isset($general_setting, $general_setting['large_image_width'], $general_setting['large_image_height'])) {
                $img = Image::make($fullPath);
                $imgWidth = $img->width();
                $imgHeight = $img->height();

                if ($imgWidth >= $imgHeight) {
                    if ($imgWidth > $general_setting['large_image_width']) {
                        $img->resize($general_setting['large_image_width'], $general_setting['large_image_height'], function ($const) {
                            $const->aspectRatio();
                        })->save(getWebPublicPath($destinationFolder . '/large-' . basename($tempFile)));
                    } else {
                        $img->save(getWebPublicPath($destinationFolder . '/large-' . basename($tempFile)));
                    }
                } else if ($imgHeight > $imgWidth) {
                    if ($imgHeight > $general_setting['large_image_height']) {
                        $img->resize($general_setting['large_image_height'], $general_setting['large_image_width'], function ($const) {
                            $const->aspectRatio();
                        })->save(getWebPublicPath($destinationFolder . '/large-' . basename($tempFile)));
                    } else {
                        $img->save(getWebPublicPath($destinationFolder . '/large-' . basename($tempFile)));
                    }
                }
                // Destroy image object to free memory
                $img->destroy();
                unset($img);
            }
        } catch (NotReadableException $e) {
            // Handle the error - log it, notify, etc.
            Log::error("The file at $fileName could not be read as a valid image. Error: " . $e->getMessage());
            return;
        } catch (\Exception $e) {
            // Handle memory exhaustion and other errors
            Log::error("Error processing image at $fileName: " . $e->getMessage());
            if (strpos($e->getMessage(), 'memory') !== false || strpos($e->getMessage(), 'Memory') !== false) {
                Log::error("Memory error detected. Consider increasing PHP memory_limit or processing smaller images.");
            }
            return;
        }
    }

    /**
     * Convert memory limit string to bytes
     */
    private function convertToBytes($memoryLimit)
    {
        $memoryLimit = trim($memoryLimit);
        $last = strtolower($memoryLimit[strlen($memoryLimit) - 1]);
        $memoryLimit = (int) $memoryLimit;

        switch ($last) {
            case 'g':
                $memoryLimit *= 1024;
            case 'm':
                $memoryLimit *= 1024;
            case 'k':
                $memoryLimit *= 1024;
        }

        return $memoryLimit;
    }
}
