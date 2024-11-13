<?php

namespace Xenan\Sitemap\Enums;

use Xenan\Sitemap\FileGenerators\AbstractFileGenerator;
use Xenan\Sitemap\FileGenerators\CsvGenerator;
use Xenan\Sitemap\FileGenerators\JsonGenerator;
use Xenan\Sitemap\FileGenerators\XmlGenerator;

enum FileType
{
    case Xml;
    case Json;
    case Csv;

    public function extension(): string
    {
        return match ($this) {
            FileType::Xml => 'xml',
            FileType::Json => 'json',
            FileType::Csv => 'csv',
        };
    }

    public function generator(): AbstractFileGenerator
    {
        return match ($this) {
            FileType::Xml => new XmlGenerator(),
            FileType::Json => new JsonGenerator(),
            FileType::Csv => new CsvGenerator(),
        };
    }
}
