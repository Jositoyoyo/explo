<?php

namespace App\Service\GenX\Generator;

class SlugString implements GenX {

    static public function exec(string $string = null) : string {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower(strip_tags($string))), '-');
    }

}
