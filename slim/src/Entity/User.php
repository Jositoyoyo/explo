<?php

namespace App\Entity;

class User {

    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $email;

    public function __construct(array $object) {
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
    }

    public function getFullname() {
        echo $this->firstname . ' ' . $this->lastname;
    }

}
