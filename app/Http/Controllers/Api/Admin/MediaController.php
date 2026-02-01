<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemporaryMedia;
use App\Traits\FileUploadTrait;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function process(Request $request)
    {
        // Always set destination folder (default to temp for FilePond/simple uploads)
        $destinationFolder = (isset($request->is_temp_media) && $request->is_temp_media)
            ? 'temp/' . uniqid()
            : 'temp/' . uniqid();

        // Accept file from 'media' (BecomeSponsor/custom) or 'logo'/'featured_image' (FilePond with name attribute)
        $file = $request->file('media')
            ?? $request->file('logo')
            ?? $request->file('featured_image');

        if (!$file) {
            return response()->json(['error' => 'No file uploaded.'], 422);
        }

        $media = $this->saveFiles($file, $destinationFolder);

        foreach ($media as $savedFile) {
            TemporaryMedia::create([
                'path' => $savedFile,
                'type' => $request->type ?? 'logo',
                'extension' => pathinfo($savedFile, PATHINFO_EXTENSION),
            ]);
        }

        // Return array format (JSON) - BecomeSponsorController expects json_decode(logo) to get path(s)
        return $media;
    }
//     public function process(Request $request)
// {
//     try {
//         // Determine destination folder
//         $destinationFolder = isset($request->is_temp_media) && $request->is_temp_media
//             ? 'temp/' . uniqid()
//             : 'uploads';

//         // Validate the media input
//         $request->validate([
//             'media' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048', // Adjust MIME types and max size if needed
//         ]);

//         // Save the file
//         $file = $request->file('media');
//         $filePath = $file->store($destinationFolder, 'public'); // Saves in storage/app/public/{destinationFolder}

//         // Save file information to database
//         TemporaryMedia::create([
//             'path' => $filePath,
//             'type' => $request->type ?? 'default',
//             'extension' => $file->getClientOriginalExtension(),
//         ]);

//         // Return success response
//         return response()->json(['path' => $filePath], 200);
//     } catch (\Exception $e) {
//         \Log::error('Media upload error: ' . $e->getMessage());
//         return response()->json(['error' => 'File upload failed.'], 500);
//     }
// }



    public function revert(Request $request)
    {
        // FilePond sends: POST with form field 'media', or DELETE with raw body
        $media = $request->input('media') ?: $request->getContent();
        if (empty(trim($media ?? ''))) {
            return response()->json(['error' => 'No media to revert.'], 422);
        }

        // Support both JSON array ["path"] and plain path string
        $paths = json_decode($media, true);
        if (!is_array($paths)) {
            $paths = [$media];
        }

        $result = $this->removeFile($paths);
        if ($result) {
            foreach ($paths as $file) {
                TemporaryMedia::wherePath($file)->delete();
            }
            return $result;
        }
        return false;
    }

    public function uploadImage(Request $request)
    {
        if (isset($request->type) && $request->type == 'only_pdf') {
            $this->validate($request, [
                'file' => 'required|mimes:pdf|max:5120',
            ]);
        } else if (isset($request->type) && $request->type == 'only_excel') {
            if (isset($request->upload_dir) && ($request->upload_dir == 'business-profiles/import' || $request->upload_dir == 'business-directory/import')) {
                $this->validate($request, [
                    'file' => 'required|mimes:xlsx,xls',
                ]);
            } else {
                $this->validate($request, [
                    'file' => 'required|mimes:xlsx,xls|max:10240',
                ]);
            }
        } else {
            $this->validate($request, [
                'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:10240',
            ]);
        }
        $image = $request->file('file');
        $name = time() . '.' . $image->getClientOriginalExtension();
        if (isset($request->upload_dir) && $request->upload_dir != '') {
            if (!file_exists(public_path() . '/documents')) {
                mkdir(public_path() . '/documents');
            }
            if (!file_exists(public_path() . '/documents/uploads')) {
                mkdir(public_path() . '/documents/uploads');
            }
            if (!file_exists(public_path() . '/documents/uploads/business-profiles')) {
                mkdir(public_path() . '/documents/uploads/business-profiles');
            }
            if (!file_exists(public_path() . '/documents/uploads/business-directory')) {
                mkdir(public_path() . '/documents/uploads/business-directory');
            }
            if (!file_exists(public_path() . '/documents/uploads/' . $request->upload_dir)) {
                mkdir(public_path() . '/documents/uploads/' . $request->upload_dir);
            }
            $destinationPath = public_path() . '/documents/uploads/' . $request->upload_dir;
            $image->move($destinationPath, $name);
            return '/documents/uploads/' . $request->upload_dir . '/' . $name;
        } else {
            $destinationPath = getWebPublicPath('images');
            $image->move($destinationPath, $name);
        }
        return '/images/' . $name;
    }
}
