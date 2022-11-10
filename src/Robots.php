<?php

namespace HumbleWordPressSetup;

use HumbleCore\Support\Facades\Filter;

class Robots
{
    public static function init()
    {
        Filter::add('robots_txt', function ($output, $public) {
            if (! $public) {
                return "User-agent: *\nDisallow: /";
            }

            return $output;
        }, 10, 2);
    }
}
