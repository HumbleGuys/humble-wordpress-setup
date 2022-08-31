<?php

namespace HumbleWordPressSetup;

use HumbleCore\Support\Facades\Action;
use HumbleCore\Support\Facades\Filter;

class Cleaner
{
    public static function removeActions()
    {
        Action::remove('wp_head', 'wp_generator');
        Action::remove('wp_head', 'rsd_link');
        Action::remove('wp_head', 'wlwmanifest_link');
        Action::remove('wp_head', 'wp_resource_hints', 2);
        Action::remove('admin_print_styles', 'print_emoji_styles');
        Action::remove('wp_head', 'print_emoji_detection_script', 7);
        Action::remove('admin_print_scripts', 'print_emoji_detection_script');
        Action::remove('wp_print_styles', 'print_emoji_styles');
        Action::remove('rest_api_init', 'wp_oembed_register_route');
        Action::remove('wp_head', 'wp_oembed_add_discovery_links');
        Action::remove('wp_head', 'wp_oembed_add_host_js');
        Action::remove('wp_head', 'rest_output_link_wp_head', 10);
    }

    public static function removeFilters()
    {
        Filter::remove('wp_mail', 'wp_staticize_emoji_for_email');
        Filter::remove('the_content_feed', 'wp_staticize_emoji');
        Filter::remove('comment_text_rss', 'wp_staticize_emoji');
        Filter::remove('oembed_dataparse', 'wp_filter_oembed_result', 10);
    }

    public static function removeScripts()
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
        wp_dequeue_style('global-styles');
    }

    public static function removePostTypeSupports()
    {
        remove_post_type_support('page', 'editor');
        remove_post_type_support('page', 'author');
        remove_post_type_support('page', 'thumbnail');
        remove_post_type_support('page', 'excerpt');
        remove_post_type_support('page', 'trackbacks');
        remove_post_type_support('page', 'comments');

        remove_post_type_support('post', 'editor');
        remove_post_type_support('post', 'author');
        remove_post_type_support('post', 'thumbnail');
        remove_post_type_support('post', 'excerpt');
        remove_post_type_support('post', 'trackbacks');
        remove_post_type_support('post', 'comments');
    }

    public static function removeComments(): void
    {
        Action::add('admin_menu', function () {
            remove_menu_page('edit-comments.php');
        });

        Action::add('wp_before_admin_bar_render', function () {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('comments');
        });
    }

    public static function removeCustomizePage(): void
    {
        Action::add('admin_menu', function () {
            global $submenu;
            unset($submenu['themes.php'][6]);
        });
    }

    public static function setMaxiumRevisions(): void
    {
        Filter::add('wp_revisions_to_keep', function () {
            return 2;
        }, 10, 2);
    }

    public static function fixNameOnFileUploads(): void
    {
        Filter::add('wp_handle_upload_prefilter', function ($file) {
            $filenameArr = explode('.', $file['name']);
            $extension = end($filenameArr);
            $fileName = sanitize_title($file['name']);
            $strLength = strlen($extension) + 1;
            $fileName = substr($fileName, 0, -$strLength);
            $file['name'] = $fileName.'.'.$extension;
            $file['name'] = strtolower($file['name']);

            return $file;
        });
    }

    public static function fixEditorCap(): void
    {
        $role_object = get_role('editor');
        $role_object->add_cap('edit_theme_options');

        if (current_user_can('editor')) {
            Action::add('admin_menu', function () {
                remove_menu_page('tools.php');
            });
        }
    }

    public static function wrapEmbeds()
    {
        Filter::add('embed_oembed_html', function ($html) {
            return '<span class="embedWrapper">'.$html.'</span>';
        }, 10, 1);
    }

    public static function removeAuthorRoute()
    {
        Action::add('template_redirect', function () {
            global $wp_query;

            if (is_author()) {
                $wp_query->set_404();
                status_header(404);
            }
        });
    }

    public static function removePostTag()
    {
        register_taxonomy('post_tag', null);
    }

    public static function allowEditorsToEditPrivacyPage($caps, $cap, $user_id, $args)
    {
        if (! is_user_logged_in()) {
            return $caps;
        }

        $user_meta = get_userdata($user_id);

        if (array_intersect(['editor', 'administrator'], $user_meta->roles)) {
            if ('manage_privacy_options' === $cap) {
                $manage_name = is_multisite() ? 'manage_network' : 'manage_options';
                $caps = array_diff($caps, [$manage_name]);
            }
        }

        return $caps;
    }

    public static function removeDashboardWidgets() {
        Action::add('wp_dashboard_setup', function() {
            global $wp_meta_boxes;

            unset($wp_meta_boxes['dashboard']);
        });
    }
}
