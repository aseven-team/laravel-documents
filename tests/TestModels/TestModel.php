<?php

namespace AsevenTeam\Documents\Tests\TestModels;

use AsevenTeam\Documents\Concerns\InteractsWithDocuments;
use AsevenTeam\Documents\Contract\HasDocuments;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model implements HasDocuments
{
    use InteractsWithDocuments;

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;
}
