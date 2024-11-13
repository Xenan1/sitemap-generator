<?php

namespace Xenan\Sitemap\DTO;

readonly class SitemapItemDTO
{
    public function __construct(
        public string $loc,
        public string $lastmod,
        public string $priority,
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
        $priority = round($page['priority'], 1);
        return new self($page['loc'], $page['lastmod'], number_format($priority), $page['changefreq']);
    }
}