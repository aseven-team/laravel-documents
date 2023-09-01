<?php

namespace AsevenTeam\Documents\Facades;

use AsevenTeam\Documents\DocumentManager;
use AsevenTeam\Documents\Drivers\DriverDecorator;
use AsevenTeam\Documents\Models\DocumentFile;
use AsevenTeam\Documents\Models\DocumentTemplate;
use Illuminate\Support\Facades\Facade;

/**
 * @method static DriverDecorator driver(?string $driver = null)
 * @method static DocumentFile create(DocumentTemplate $template, array $variables = [], array $options = [])
 * @method static DocumentFile createFromHtml(string $html, array $options = [])
 */
class Document extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DocumentManager::class;
    }
}
