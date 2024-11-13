<?php

namespace Xenan\Sitemap\Validators;

use DateTime;
use ValueError;
use Xenan\Sitemap\Exceptions\InvalidSitemapValueException;
use Xenan\Sitemap\Exceptions\MissingSitemapFieldException;

class SitemapPageValidator
{
    public function __construct(private array $page) {}

    public static function validate(array $page): void
    {
        $validator = new static($page);
        $validator->run();
    }

    private function run(): void
    {
        $this->validatePageFields();
        $this->validateLoc();
        $this->validateLastMod();
        $this->validatePriority();
        $this->validateChangefreq();
    }

    private function validatePageFields(): void
    {
        foreach (['loc', 'lastmod', 'priority', 'changefreq'] as $field) {
            if (!array_key_exists($field, $this->page)) {
                $field === 'loc'
                    ? throw new MissingSitemapFieldException('Missing loc field')
                    : throw new MissingSitemapFieldException('Missing required field '. $field.' in page '. $this->page['loc']);
            }
        }
    }

    private function validateLoc(): void
    {
        if (filter_var($this->page['loc'], FILTER_VALIDATE_URL) === false) {
            throw new InvalidSitemapValueException('Invalid URL for loc in page ' . $this->page['loc']);
        }
    }

    private function validateLastmod(): void
    {
        $lastmod = $this->page['lastmod'];
        $date = DateTime::createFromFormat('Y-m-d', $lastmod);

        $isValidFormat = $date && $date->format('Y-m-d') === $lastmod;
        $isValidLastmod = $isValidFormat && $date <= new DateTime();

        if (!$isValidLastmod) {
            throw new InvalidSitemapValueException('Invalid lastmod format or date in page '. $this->page['loc']);
        }
    }

    private function validatePriority(): void
    {
        $priority = round((float) $this->page['priority'], 1);

        if ($priority < 0 || $priority > 1) {
            throw new InvalidSitemapValueException('Invalid priority value in page '. $this->page['loc']);
        }
    }

    private function validateChangefreq(): void
    {
        $validFrequencies = ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];

        if (!in_array($this->page['changefreq'], $validFrequencies)) {
            throw new InvalidSitemapValueException('Invalid changefreq value in page '. $this->page['loc']);
        }
    }
}