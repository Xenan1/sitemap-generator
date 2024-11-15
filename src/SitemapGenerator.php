<?php

namespace Xenan\Sitemap;

use Xenan\Sitemap\DTO\SitemapItemDTO;
use Xenan\Sitemap\Enums\FileType;
use Xenan\Sitemap\Validators\FilePathValidator;
use Xenan\Sitemap\Validators\SitemapPageValidator;

class SitemapGenerator
{
    private function __construct(
        private array $pages,
        private FileType $fileType,
        private string $destinationPath
    ) {}

    public static function run(array $pages, FileType $fileType, string $destinationPath): void
    {
        $generator = new self($pages, $fileType, $destinationPath);
        $generator->validateDestination();
        $generator->validatePages();
        $generator->generate();
    }

    private function validateDestination(): void
    {
        FilePathValidator::validatePathString($this->destinationPath);

        $dirname = dirname($this->destinationPath);
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, true);
        }

        FilePathValidator::validateForFileWriting($this->destinationPath, $this->fileType);
    }

    private function validatePages(): void
    {
        foreach ($this->pages as $page) {
            SitemapPageValidator::validate($page);
        }
    }

    private function generate(): void
    {
        $pages = SitemapItemDTO::fromPages($this->pages);
        $this->fileType->generator()->run($pages, $this->destinationPath);
    }
}