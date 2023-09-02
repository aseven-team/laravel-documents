<?php

namespace AsevenTeam\Documents;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DocumentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-documents')
            ->hasConfigFile()
            ->hasMigration('create_document_templates_table');
    }
}
