<?php

namespace App\Service\GenX;

/**
 * @author Jose Antonio Martinez <jositoyoyo2@hotmail.com>
 * Clase Simple para generar todo tipo de claves, slug etc
 */

class GenX {

    static public function TokenizenSlug() : string {
        return Generator\TokenizenSlug::exec();
    }
    
    static public function SlugString(string $string) : string {
        return Generator\SlugString::exec($string);
    }
    
    static public function UniqueFileName() : string {
        return Generator\UniqueFileName::exec();
    }
    
    static public function RandomPassword() : string {
        return Generator\RandomPassword::exec();
    }
    
}
