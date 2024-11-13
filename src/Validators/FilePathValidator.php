<?php

namespace Xenan\Sitemap\Validators;

use Xenan\Sitemap\Enums\FileType;
use ValueError;

class FilePathValidator
{
    public function __construct(private string $path) {}

    /**
     * @throws ValueError
     */
    public static function validateForFileWriting(string $path, FileType $expectedFileType): void
    {
        $validator = new static($path);
        $validator->validateWritingPermissions();
        $validator->validateFileExtension($expectedFileType);
    }

    private function validateWritingPermissions(): void
    {
        if (!is_writable(dirname($this->path))) {
            throw new ValueError("Destination path $this->path is not writable");
        }
    }

    public static function validatePathString($path): void
    {
        if (!preg_match('/^[^*?"<>|:]*$/', $path)) {
            throw new ValueError('Invalid file path');
        }
    }

    private function validateFileExtension(FileType $expectedFileType): void
    {
        $pathParts = explode('.', $this->path);
        $extension = end($pathParts);

        $expectedExtension = $expectedFileType->extension();
        if ($expectedExtension !== $extension) {
            throw new ValueError('Unexpected file extension. Expected '. $expectedExtension);
        }
    }
}