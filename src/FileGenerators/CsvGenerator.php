<?php

namespace Xenan\Sitemap\FileGenerators;

use Xenan\Sitemap\DTO\SitemapItemDTO;

class CsvGenerator extends AbstractFileGenerator
{
    private array $data = [];

    protected function prepare(): void
    {
        $this->data[] = ['loc', 'lastmod', 'priority', 'changefreq'];
    }

    protected function addSitemapItem(SitemapItemDTO $item): void
    {
        $this->data[] = [
            $item->loc,
            $item->lastmod,
            $item->priority,
            $item->changefreq,
        ];
    }

    protected function saveFile(): void
    {
        $file = fopen($this->getDestinationPath(), 'w');

        foreach ($this->data as $csvRow) {
            fputcsv($file, $csvRow);
        }

        fclose($file);
    }
}