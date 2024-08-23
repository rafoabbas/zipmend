<?php

namespace App\Models\Mongo;

use MongoDB\Laravel\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;

    protected $connection = 'mongodb';

    protected $collection = 'cities';
}
