<?php

namespace AsevenTeam\Documents\Facades;

use AsevenTeam\Documents\DocumentFile;
use AsevenTeam\Documents\DocumentManager;
use AsevenTeam\Documents\Drivers\DriverDecorator;
use Illuminate\Support\Facades\Facade;

/**
 * @method static DriverDecorator driver(?string $driver = null)
 * @method static DocumentFile create(string $templateKey, array $variables = [], array $options = [])
 * @method static DocumentFile createFromHtml(string $html, array $options = [])
 */
class Document extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DocumentManager::class;
    }
}
