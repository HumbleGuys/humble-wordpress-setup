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
}
