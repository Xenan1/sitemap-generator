<?php

namespace Xenan\Sitemap\Validators;

use Xenan\Sitemap\Enums\FileType;
use ValueError;
use Xenan\Sitemap\Exceptions\PathPermissionsException;
use Xenan\Sitemap\Exceptions\PathStringException;
use Xenan\Sitemap\Exceptions\WrongExtensionException;

class FilePathValidator
{
    public function __construct(private string $path) {}

    /**
     * @throws PathPermissionsException
     * @throws WrongExtensionException
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
            throw new PathPermissionsException("Destination path $this->path is not writable");
        }
    }

    /**
     * @throws PathStringException
     */
    public static function validatePathString($path): void
    {
        if (!preg_match('/^[^*?"<>|:]*$/', $path)) {
            throw new PathStringException('Invalid file path');
        }
    }

    private function validateFileExtension(FileType $expectedFileType): void
    {
        $pathParts = explode('.', $this->path);
        $extension = end($pathParts);

        $expectedExtension = $expectedFileType->extension();
        if ($expectedExtension !== $extension) {
            throw new WrongExtensionException("Unexpected file extension. Expected $expectedExtension, $extension given");
        }
    }
}