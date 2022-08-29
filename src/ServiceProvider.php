<?php

namespace HumbleWordPressSetup;

use HumbleCore\Support\Facades\Action;
use HumbleCore\Support\Facades\Filter;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function register(): void
    {
        Filter::add('upload_mimes', function ($mimes) {
            return Arr::add($mimes, 'svg', 'image/svg+xml');
        });

        Action::add('init', [Cleaner::class, 'removeActions']);
        Action::add('init', [Cleaner::class, 'removeFilters']);
        Action::add('wp_enqueue_scripts', [Cleaner::class, 'removeScripts'], 100);
    }
}
