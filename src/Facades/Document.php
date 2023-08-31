<?php

namespace AsevenTeam\Documents\Facades;

use AsevenTeam\Documents\Contract\HasDocuments;
use AsevenTeam\Documents\DocumentManager;
use AsevenTeam\Documents\Drivers\DriverDecorator;
use AsevenTeam\Documents\Models\DocumentFile;
use AsevenTeam\Documents\Models\DocumentTemplate;
use Illuminate\Support\Facades\Facade;

/**
 * @method static DriverDecorator driver(?string $driver = null)
 * @method static DocumentFile create(HasDocuments $model, DocumentTemplate $template, array $variables = [], array $options = [], ?string $documentType = null)
 * @method static DocumentFile createFromHtml(HasDocuments $model, string $html, array $options = [], ?string $documentType = null)
 */
class Document extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DocumentManager::class;
    }
}
