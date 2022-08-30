<?php

namespace HumbleWordPressSetup;

use HumbleCore\Support\Facades\Action;
use HumbleCore\Support\Facades\Filter;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function register(): void
    {
        Filter::add('upload_mimes', [Assets::class, 'allowSvgsInUpload']);
        Action::add('init', [Assets::class, 'removeWpImageSizes']);
        Action::add('init', [Assets::class, 'setImageSizes']);

        Action::add('init', [Cleaner::class, 'removeActions']);
        Action::add('init', [Cleaner::class, 'removeFilters']);
        Action::add('init', [Cleaner::class, 'removePostTypeSupports']);
        Action::add('wp_enqueue_scripts', [Cleaner::class, 'removeScripts'], 100);
    }
}
