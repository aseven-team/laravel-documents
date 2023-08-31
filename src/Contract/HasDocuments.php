<?php

namespace AsevenTeam\Documents\Contract;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasDocuments
{
    public function documents(): MorphMany;
}
