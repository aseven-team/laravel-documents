<?php

namespace AsevenTeam\Documents\Tests;

use AsevenTeam\Documents\DocumentServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'AsevenTeam\\Documents\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            DocumentServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        Schema::create('test_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        $createDocumentTemplatesTable = include __DIR__.'/../database/migrations/create_document_templates_table.php';
        $createDocumentTemplatesTable->up();
    }
}
