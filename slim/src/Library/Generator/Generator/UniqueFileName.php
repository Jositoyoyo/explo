<?php

namespace App\Service\GenX\Generator;

class UniqueFileName implements GenX {

    static public function exec(string $string = null) :string {
        return (string) md5(uniqid());
    }

}
