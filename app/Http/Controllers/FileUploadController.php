<?php

namespace App\Http\Controllers;

use App\Services\File\FileUploadFactory;
use App\Services\File\FileProcessor;
use App\Services\Image\ImageProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function __construct(protected FileUploadFactory $fileUploadFactory)
    {
    }

    public function showForm()
    {
        return view('file-upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // 50MB max
            'directory' => 'nullable|string',
            'custom_filename' => 'nullable|string',
            'disk' => 'nullable|string',
            // Image-specific options
            'quality' => 'nullable|integer|min:1|max:100',
            'format' => 'nullable|string|in:webp,png,jpg,jpeg',
            // File-specific options
            'allowed_extensions' => 'nullable|string',
            'max_size' => 'nullable|integer|min:1|max:100',
        ]);
        $processor = $this->fileUploadFactory->get($request->file('file'));

        $res = $processor->load($request->file('file'))->convert('webp')->compress('70')->saveAndGetInfo('uploads', 'public');

        dd($res);
        return back()->with('success', ucfirst($res['filename']) . ' uploaded successfully!')
            ->with('fileInfo', array_merge($res, [
                'type' => $this->fileUploadFactory->isImage($request->file('file')) ? 'image' : 'file',
                    'custom_filename' => $request->input('custom_filename'),
                    'directory' => $request->input('directory'),
                    'disk' => $request->input('disk'),
                ]
            ));
    }
}

