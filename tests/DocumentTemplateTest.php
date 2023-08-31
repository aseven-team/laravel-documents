<?php

use AsevenTeam\Documents\Models\DocumentTemplate;

it('can create document template', function () {
    $document = DocumentTemplate::create([
        'name' => 'new template',
        'template' => 'template',
        'variables' => [
            'variable1' => 'default_value',
        ],
    ]);

    expect($document->exists)->toBeTrue();
});
