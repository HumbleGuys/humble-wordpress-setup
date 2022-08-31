<?php

namespace HumbleWordPressSetup;

use HumbleCore\Support\Facades\Filter;

class RankMath
{
    public static function metaboxPriority()
    {
        Filter::add('rank_math/metabox/priority', function($priority) {
            return 'low';
        });
    }
}
