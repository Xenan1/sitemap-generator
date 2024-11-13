<?php

namespace Xenan\Sitemap\FileGenerators;

use Xenan\Sitemap\DTO\SitemapItemDTO;

abstract class AbstractFileGenerator
{
    private string $destinationPath;
    /**
     * @param array<SitemapItemDTO> $pages
     * @param string $destinationPath
     * @return void
     */

    abstract protected function prepare(): void;
    abstract protected function addSitemapItem(SitemapItemDTO $item): void;
    abstract protected function saveFile(): void;

    public function run(array $pages, string $destinationPath): void
    {
        $this->destinationPath = $destinationPath;

        $this->prepare();
        foreach ($pages as $page) {
            $this->addSitemapItem($page);
        }
        $this->saveFile();
    }

    protected function getDestinationPath(): string
    {
        return $this->destinationPath;
    }
}