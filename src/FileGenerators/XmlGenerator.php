<?php

namespace Xenan\Sitemap\FileGenerators;

use Xenan\Sitemap\DTO\SitemapItemDTO;
use SimpleXMLElement;

class XmlGenerator extends AbstractFileGenerator
{
    private SimpleXMLElement $xml;

    protected function prepare(): void
    {
        $this->xml = new SimpleXMLElement('<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">');

    }

    protected function addSitemapItem(SitemapItemDTO $item): void
    {
        $xmlItem = $this->xml->addChild('url');
        $xmlItem->addChild('loc', $item->loc);
        $xmlItem->addChild('lastmod', $item->lastmod);
        $xmlItem->addChild('priority', $item->priority);
        $xmlItem->addChild('changefreq', $item->changefreq);
    }

    protected function saveFile(): void
    {
        $this->xml->asXML($this->getDestinationPath());
    }
}