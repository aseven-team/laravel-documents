<?php

use AsevenTeam\Documents\DocumentFile;

it('can create temporary file', function () {
    $file = new DocumentFile('content');

    expect($file->path)->toBeFile();
});

it('can delete file', function () {
    $file = new DocumentFile('content');

    expect($file->path)->toBeFile();

    $file->delete();

    expect($file->path)->not->toBeFile();
});
