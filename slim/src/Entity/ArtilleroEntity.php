<?php

namespace src\Entity;

class ArtilleroEntity {

    private $id;
    private $nombre;
    private $apellidos;
    private $ffin;
    private $ambito;
    private $pre = 'arti';
    private $post = 'cadu';
    private $custom;

    public function __construct(object $artillero = null) {
        if ($artillero) {
            $this->id = $artillero->id ? $artillero->id : null;
            $this->nombre = $artillero->nombre;
            $this->apellidos = $artillero->apellidos;
            $this->ffin = $artillero->ffin;
            $this->ambito = $artillero->ambito;
        }
    }

    public function nombreCompleto() {
        return $this->nombre . ' ' . $this->apellidos;
    }

    public function getAmbito() {
        return $this->ambito;
    }

    public function custom() {
        $this->custom = $this->pre . $this->id . $this->post . str_replace('-', '', $this->ffin);
        return $this->custom;
    }

    public function link() {
        $html = "La cartilla del artillero 
                <a href='edit_artilleros.php?pk='$this->custom'> 
                 $this->nombre $this->apellidos</a>
                caduca el próximo $this->ffin 
                </a>";

        return $html;
    }

}
