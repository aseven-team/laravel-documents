<?php

use AsevenTeam\Documents\Facades\Document;
use AsevenTeam\Documents\Models\DocumentFile;
use AsevenTeam\Documents\Models\DocumentTemplate;

it('can render document from template', function () {
    $template = DocumentTemplate::factory()->create();

    $document = Document::create($template);

    expect($document)
        ->toBeInstanceOf(DocumentFile::class)
        ->and($document->exists)->toBeTrue();
});

it('can render document from html', function () {
    $document = Document::createFromHtml('<div>test html string</div>');

    expect($document)
        ->toBeInstanceOf(DocumentFile::class)
        ->and($document->exists)->toBeTrue();
});
