<?php

namespace App\Services\File\Contracts;

use Illuminate\Http\UploadedFile;

interface FileProcessorInterface
{
    /**
     * Load a file from an uploaded file
     *
     * @param UploadedFile $source
     * @return self
     */
    public function load(UploadedFile $source): self;

    /**
     * Set custom filename for the file
     *
     * @param string $filename Custom filename
     * @return self
     */
    public function setFilename(string $filename): self;

    /**
     * Set the directory path where file will be stored
     *
     * @param string $directory Directory path
     * @return self
     */
    public function setDirectory(string $directory): self;

    /**
     * Validate file size
     *
     * @param int $maxSizeInMB Maximum file size in megabytes
     * @return self
     * @throws \Exception If file exceeds max size
     */
    public function validateSize(int $maxSizeInMB): self;

    /**
     * Validate file extension
     *
     * @param array $allowedExtensions Array of allowed extensions
     * @return self
     * @throws \Exception If file extension is not allowed
     */
    public function validateExtension(array $allowedExtensions): self;

    /**
     * Save the file and return its information
     *
     * @param string $path Path where the file will be saved
     * @param string $disk Storage disk name
     * @return array Array containing path, url, filename, size, extension, and mime_type
     */
    public function saveAndGetInfo(string $path, string $disk): array;
}

