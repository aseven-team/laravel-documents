<?php

namespace Aseventeam\Documents;

use Aseventeam\Documents\Commands\DocumentsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DocumentsServiceProvider extends PackageServiceProvider
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
            ->hasMigration('create_laravel-documents_table')
            ->hasCommand(DocumentsCommand::class);
    }
}
