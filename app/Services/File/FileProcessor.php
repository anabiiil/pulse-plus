<?php

namespace App\Services\File;

use App\Services\File\Contracts\FileProcessorInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileProcessor implements FileProcessorInterface
{
    protected ?UploadedFile $file = null;
    protected ?string $customFilename = null;
    protected string $directory = 'files';
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.default', 'public');
    }

    public function load(UploadedFile $source): self
    {
        $this->file = $source;
        return $this;
    }

    public function setFilename(string $filename): self
    {
        $this->customFilename = $filename;
        return $this;
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = trim($directory, '/');
        return $this;
    }

    public function validateSize(int $maxSizeInMB): self
    {
        if (!$this->file) {
            throw new \RuntimeException('No file loaded. Call load() first.');
        }

        $fileSizeInMB = $this->file->getSize() / 1024 / 1024;

        if ($fileSizeInMB > $maxSizeInMB) {
            throw new \RuntimeException("File size ({$fileSizeInMB}MB) exceeds maximum allowed size ({$maxSizeInMB}MB).");
        }

        return $this;
    }

    public function validateExtension(array $allowedExtensions): self
    {
        if (!$this->file) {
            throw new \RuntimeException('No file loaded. Call load() first.');
        }

        $extension = strtolower($this->file->getClientOriginalExtension());
        $allowedExtensions = array_map('strtolower', $allowedExtensions);

        if (!in_array($extension, $allowedExtensions, true)) {
            throw new \RuntimeException("File extension '{$extension}' is not allowed. Allowed: " . implode(', ', $allowedExtensions));
        }

        return $this;
    }

    public function saveAndGetInfo(string $path, string $disk): array
    {
        if (!$this->file) {
            throw new \RuntimeException('No file loaded. Call load() first.');
        }


        // Store the file
        Storage::disk($disk)->put($path, file_get_contents($this->file->getRealPath()));

        return [
            'path' => $path,
            'url' => Storage::disk($disk)->url($path),
            'filename' => $this->file->getClientOriginalName(),
            'stored_name' => basename($path),
            'size' => round($this->file->getSize() / 1024 / 1024, 2), // Size in MB
            'size_bytes' => $this->file->getSize(),
            'extension' => $this->file->getClientOriginalExtension(),
            'mime_type' => $this->file->getMimeType(),
        ];
    }


    /**
     * Get file extension
     *
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->file?->getClientOriginalExtension();
    }

    /**
     * Get file size in bytes
     *
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->file?->getSize();
    }

    /**
     * Get file MIME type
     *
     * @return string|null
     */
    public function getMimeType(): ?string
    {
        return $this->file?->getMimeType();
    }

    /**
     * Get original filename
     *
     * @return string|null
     */
    public function getOriginalName(): ?string
    {
        return $this->file?->getClientOriginalName();
    }
}

