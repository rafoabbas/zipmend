<?php

namespace App\Models\Account;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key',
        'status',
        'permissions',
        'last_used_at',
        'last_expired_at'
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'permissions' => 'array',
            'last_used_at' => 'datetime',
            'last_expired_at' => 'datetime'
        ];
    }

    public function checkPermission($permission): bool
    {
        return ! in_array($permission, $this->permissions);
    }

    public function checkLastExpired(): bool
    {
        return $this->last_expired_at->isPast();
    }

    public function updateLastUsed(): bool
    {
        return $this->update([
            'last_used_at' => now()
        ]);
    }
}
