<?php

namespace AsevenTeam\Documents;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DocumentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-documents')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations([
                'create_document_templates_table',
                'create_document_files_table',
            ]);
    }
}
