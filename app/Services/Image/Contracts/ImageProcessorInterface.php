<?php

namespace App\Services\Image\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageProcessorInterface
{
    /**
     * Load an image from an uploaded file
     *
     * @param UploadedFile $source
     * @return self
     */
    public function load(UploadedFile $source): self;

    /**
     * Compress the image with specified quality
     *
     * @param int $quality Quality level (1-100)
     * @return self
     */
    public function compress(int $quality = 85): self;

    /**
     * Convert the image to specified format
     *
     * @param string $format Target format (webp, png, jpg, jpeg)
     * @return self
     */
    public function convert(string $format): self;

    /**
     * Save the processed image and return its information
     *
     * @param string $path Path where the image will be saved
     * @param string $disk Storage disk name
     * @return array Array containing path, url, filename, size, format, and mime_type
     */
    public function saveAndGetInfo(string $path, string $disk): array;

    public function deleteImage(string $imagePath): static;
}
