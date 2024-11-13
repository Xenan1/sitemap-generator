<?php

namespace Xenan\Sitemap\FileGenerators;

use Xenan\Sitemap\DTO\SitemapItemDTO;

class JsonGenerator extends AbstractFileGenerator
{
    private array $data;

    protected function prepare(): void
    {
        $this->data = [];
    }

    protected function addSitemapItem(SitemapItemDTO $item): void
    {
        $this->data[] = [
            'loc' => $item->loc,
            'lastmod' => $item->lastmod,
            'priority' => $item->priority,
            'changefreq' => $item->changefreq,
        ];
    }

    protected function saveFile(): void
    {
        $content = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        file_put_contents($this->getDestinationPath(), $content);
    }
}