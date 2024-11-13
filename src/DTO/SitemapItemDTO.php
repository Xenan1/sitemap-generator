<?php

namespace Xenan\Sitemap\DTO;

readonly class SitemapItemDTO
{
    public function __construct(
        public string $loc,
        public string $lastmod,
        public float $priority,
        public string $changefreq
    ) {}

    /**
     * @return array<self>
     */
    public static function fromPages(array $pages): array
    {
        return array_map(function (array $page) {
            return self::fromPage($page);
        }, $pages);
    }

    public static function fromPage(array $page): self
    {
        return new self($page['loc'], $page['lastmod'], $page['priority'], $page['changefreq']);
    }
}