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

        Action::add('init', [Cleaner::class, 'removeComments']);
        Action::add('init', [Cleaner::class, 'removeCustomizePage']);
        Action::add('init', [Cleaner::class, 'setMaxiumRevisions']);
        Action::add('init', [Cleaner::class, 'fixNameOnFileUploads']);
        Action::add('admin_init', [Cleaner::class, 'fixEditorCap']);
        Action::add('init', [Cleaner::class, 'wrapEmbeds']);
        Action::add('init', [Cleaner::class, 'removeAuthorRoute']);
        Action::add('init', [Cleaner::class, 'removePostTag']);
        Action::add('admin_init', [Cleaner::class, 'removeDashboardWidgets']);
        Action::add('admin_init', [Cleaner::class, 'removeThemeFromMenu']);

        Action::add('map_meta_cap', [Cleaner::class, 'allowEditorsToEditPrivacyPage'], 1, 4);

        Action::add('init', [RankMath::class, 'metaboxPriority']);
    }
}
