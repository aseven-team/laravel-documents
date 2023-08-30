<?php

namespace Aseventeam\Documents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aseventeam\Documents\Documents
 */
class Documents extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aseventeam\Documents\Documents::class;
    }
}
