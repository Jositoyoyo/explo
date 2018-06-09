<?php

namespace App\Service\GenX\Generator;

class TokenizenSlug implements GenX {

    static public function exec(string $string = null) : string {
        return (string) md5(uniqid(rand(0, 999999), true));
    }

}
