<?php

namespace App\Services\Image;

use App\Services\Image\Contracts\ImageProcessorInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

class ImageProcessor implements ImageProcessorInterface
{
    protected ImageInterface $image;
    protected int $quality = 85;
    protected string $format = 'webp';
    protected string $disk = 'public';
    protected ?UploadedFile $sourceFile = null;

    public function __construct(protected ImageManager $imageManager)
    {
        $this->disk = config('image.disk', 'public');
    }

    public function load(UploadedFile $source): self
    {
        $this->sourceFile = $source;
        $this->image = $this->imageManager->read($source);
        return $this;
    }

    public function compress(int $quality = 85): self
    {
        $this->quality = $quality;
        return $this;
    }

    public function convert(string $format): self
    {
        $this->format = strtolower($format);
        return $this;
    }

    public function saveAndGetInfo(string $path, string $disk): array
    {
        $encoded = $this->formatTo();
        $fullPath = $path . '/' . pathinfo($this->sourceFile->hashName(), PATHINFO_FILENAME) . '.' . $this->format;
        Storage::disk($disk)->put($fullPath, $encoded);
        return [
            'path' => $fullPath,
            'url' => Storage::disk($disk)->url($fullPath),
            'filename' => $this->sourceFile?->getClientOriginalName() ?? 'unknown',
            'size' => round(strlen($encoded) / 1024 / 1024, 2),
            'format' => $this->format,
            'mime_type' => 'image/' . $this->format,
        ];
    }

    private function formatTo(): string
    {
        return match ($this->format) {
            'png' => $this->image->toPng(),
            'jpg', 'jpeg' => $this->image->toJpeg($this->quality),
            default => $this->image->toWebp($this->quality),
        };
    }

    public function deleteImage($path): static
    {
        //delete image if exists
        if (Storage::disk($this->disk)->exists($path)) {
            Storage::disk($this->disk)->delete($path);
        }
        return $this;

    }
}
