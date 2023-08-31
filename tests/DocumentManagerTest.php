<?php

use AsevenTeam\Documents\Facades\Document;
use AsevenTeam\Documents\Models\DocumentFile;
use AsevenTeam\Documents\Models\DocumentTemplate;
use AsevenTeam\Documents\Tests\TestModels\TestModel;

it('can render document from template', function () {
    $template = DocumentTemplate::factory()->create();
    $model = TestModel::create(['name' => 'test']);

    $document = Document::create($model, $template);

    expect($document)
        ->toBeInstanceOf(DocumentFile::class)
        ->and($document->exists)->toBeTrue();
});

it('can render document from html', function () {
    $model = TestModel::create(['name' => 'test']);

    $document = Document::createFromHtml($model, '<div>test html string</div>');

    expect($document)
        ->toBeInstanceOf(DocumentFile::class)
        ->and($document->exists)->toBeTrue();
});
