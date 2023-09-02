<?php

use AsevenTeam\Documents\Facades\Document;
use AsevenTeam\Documents\Models\DocumentTemplate;

it('can render document from template', function () {
    $template = DocumentTemplate::factory()->create();

    $document = Document::create($template->key);

    expect($document->path)->toBeFile();
});

it('can render document from html', function () {
    $document = Document::createFromHtml('<div>test html string</div>');

    expect($document->path)->toBeFile();
});
