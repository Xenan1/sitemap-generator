<?php

namespace Enums;

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
}
