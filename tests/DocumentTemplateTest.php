<?php

use AsevenTeam\Documents\Models\DocumentTemplate;

it('can create document template', function () {
    $document = DocumentTemplate::create([
        'key' => 'test-template',
        'name' => 'new template',
        'content' => 'template',
        'variables' => [
            'variable1' => 'default_value',
        ],
    ]);

    expect($document->exists)->toBeTrue();
});
