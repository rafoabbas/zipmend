<?php

namespace App\Models\Mongo;

use MongoDB\Laravel\Eloquent\Model;

class VehicleType extends Model
{
    public $timestamps = false;

    protected $connection = 'mongodb';

    protected $collection = 'vehicleTypes'; //vehicleTypes
}
