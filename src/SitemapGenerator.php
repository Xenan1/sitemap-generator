<?php

use Enums\FileType;
use Validators\FilePathValidator;
use Validators\SitemapPageValidator;

class SitemapGenerator
{
    private function __construct(
        /**
         * @var
         */
        private array $pages,
        private FileType $fileType,
        private string $destinationPath
    )
    {
        $this->validateDestination();
    }

    public static function run(array $pages, FileType $fileType, string $destinationPath): void
    {
        $generator = new self($pages, $fileType, $destinationPath);
        $generator->validateDestination();
        $generator->validatePages();
    }

    private function validateDestination(): void
    {
        FilePathValidator::validatePathString($this->destinationPath);

        if (!is_dir($this->destinationPath)) {
            mkdir($this->destinationPath, 0755, true);
        }

        FilePathValidator::validateForFileWriting($this->destinationPath, $this->fileType);
    }

    private function validatePages(): void
    {
        foreach ($this->pages as $page) {
            SitemapPageValidator::validate($page);
        }
    }
}