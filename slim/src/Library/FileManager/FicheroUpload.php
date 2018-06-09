<?php

namespace src\Library\FileManager;


class FicheroUpload {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var string
     */
    protected $tmpName;

    /**
     * @var int
     */
    protected $error;


    public function __construct($file) {
        $this->name = (isset($file['name']) ? $file['name'] : NULL);
        $this->type = (isset($file['type']) ? $file['type'] : NULL);
        $this->size = (isset($file['size']) ? $file['size'] : NULL);
        $this->tmpName = (isset($file['tmp_name']) ? $file['tmp_name'] : NULL);
        $this->error = (isset($file['error']) ? $file['error'] : NULL);
    }

    public function getName() {
        return $this->name;
    }
    public function getType() {
        return $this->type;
    }
    public function getSize() {
        return $this->size;
    }
    public function getTmpName() {
        return $this->tmpName;
    }
    public function getError() {
        return $this->error;
    }
}