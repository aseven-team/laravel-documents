<?php

namespace AsevenTeam\Documents\Concerns;

use AsevenTeam\Documents\Models\DocumentFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait InteractsWithDocuments
{
    public function documents(): MorphMany
    {
        return $this->morphMany(DocumentFile::class, 'model');
    }
}
