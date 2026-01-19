<?php

namespace App\Services\File;

use App\Services\File\Contracts\FileProcessorInterface;
use App\Services\Image\Contracts\ImageProcessorInterface;
use App\Services\Image\ImageProcessor;
use Illuminate\Http\UploadedFile;

class FileUploadFactory
{
    protected const IMAGE_MIME_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',
        'image/bmp',
    ];

    public function __construct(
        protected ImageProcessor $imageProcessor,
        protected FileProcessor $fileProcessor
    ) {
    }

    /**
     * Create appropriate processor based on file type
     *
     * @param UploadedFile $file
     * @return ImageProcessorInterface|FileProcessorInterface
     */
    public function get(UploadedFile $file): ImageProcessorInterface|FileProcessorInterface
    {
        if ($this->isImage($file)) {
            return $this->imageProcessor;
        }

        return $this->fileProcessor;
    }

    /**
     * Check if uploaded file is an image
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function isImage(UploadedFile $file): bool
    {
        $mimeType = $file->getMimeType();
        return in_array($mimeType, self::IMAGE_MIME_TYPES, true);
    }

    /**
     * Get the type of the file
     *
     * @param UploadedFile $file
     * @return string
     */
    public function getFileType(UploadedFile $file): string
    {
        return $this->isImage($file) ? 'image' : 'file';
    }
}

