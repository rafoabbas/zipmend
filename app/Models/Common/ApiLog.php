<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'api_key',
        'connection_ip',
        'headers',
        'request',
        'response',
        'method',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'headers' => 'json',
            'request' => 'json',
        ];
    }
}
