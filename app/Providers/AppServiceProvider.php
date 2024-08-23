<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Request::macro('clientIp', function () {
            if ($cloudflareIp = $this->input('metadata.cf-connecting-ip')) {
                return $cloudflareIp;
            } elseif ($forwardedIp = $this->input('metadata.x-forwarded-for.0')) {
                return $forwardedIp;
            } else {
                return $this->header('cf-connecting-ip') ?? $this->header('x-forwarded-for') ?? $this->ip();
            }
        });
    }

    public function boot(): void
    {
        //
    }
}
