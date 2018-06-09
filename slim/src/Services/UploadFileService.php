<?php

namespace src\Services;

use src\Library\FileManager\Utils;
use src\Repository\Plantillas\PlantillasRepository;

class UploadFileService {

    private $mimes_validos_adjuntos = null;
    private $extensiones_validas_adjuntos = ['docx'];
    private $config;
    private $app;

    const FOR_PDF = 1;
    const FOR_RTF = 2;
    const BYTES_MB = 1048576;
    const NUM_MIN_FICHEROS_SUBIDA = 0;
    const NUM_MAX_FICHEROS_SUBIDA = 5;
    const TAM_MAX_FICHERO = 5242880;
    const VALIDAR_MIME_TYPE = false;

    public function __construct($app) {
        $this->app = $app;
    }

    public function guardar() {

        $ficheros_validos = array();
        $errores_ficheros = array();
        $tam_max_file_en_mb = $this->getTamMaxInMb();

        for ($i = 1; $i <= self::NUM_MAX_FICHEROS_SUBIDA; $i++) {
            if (!isset($_FILES['fichero' . $i])) {
                continue;
            }

            if (
                    $_FILES['fichero' . $i]['error'] !== UPLOAD_ERR_OK &&
                    $_FILES['fichero' . $i]['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                $errores_ficheros[] = 'El fichero nº ' . $i . ' no ha sido ' .
                        'subido correctamente (código ' . $_FILES['fichero' . $i]['error'] . ')';
                continue;
            }

            if ($_FILES['fichero' . $i]['error'] === UPLOAD_ERR_OK) {
                if ($_FILES['fichero' . $i]['size'] > self::TAM_MAX_FICHERO) {
                    $errores_ficheros[] = 'El tamaño del fichero "' .
                            htmlspecialchars($_FILES['fichero' . $i]['name']) . '" (' .
                            number_format(round($_FILES['fichero' . $i]['size'] / self::BYTES_MB, 2), 2) . ' MB' .
                            ') no puede ser mayor ' .
                            'a ' . $tam_max_file_en_mb;
                    continue;
                }

                if (self::VALIDAR_MIME_TYPE && !in_array(strtolower($_FILES['fichero' . $i]['type']), $this->mimes_validos_adjuntos)) {
                    $errores_ficheros[] = 'El mime type del fichero "' .
                            htmlspecialchars($_FILES['fichero' . $i]['name']) . '" no es válido (' .
                            $_FILES['fichero' . $i]['type'] . ')';
                    continue;
                }

                $extension = strtolower(pathinfo($_FILES['fichero' . $i]['name'], PATHINFO_EXTENSION));
                if (!in_array($extension, $this->extensiones_validas_adjuntos)) {
                    $errores_ficheros[] = 'La extensión del fichero "' .
                            htmlspecialchars($_FILES['fichero' . $i]['name']) . '" no es válida.' .
                            ' Solo se permiten las extensiones ' . implode(', ', $this->extensiones_validas_adjuntos);
                    continue;
                }

                $ficheros_validos[] = $_FILES['fichero' . $i];
            }
        }

        if (count($errores_ficheros) > 0) {
            $str_error = '';

            foreach ($errores_ficheros as $error_fichero) {
                $str_error .= $error_fichero . '<br/>';
            }

            throw new Exception($str_error);
        }

        if (count($ficheros_validos) < self::NUM_MIN_FICHEROS_SUBIDA) {
            throw new Exception('Es obligatorio adjuntar por lo menos ' .
            self::NUM_MIN_FICHEROS_SUBIDA . ' fichero' . (self::NUM_MIN_FICHEROS_SUBIDA !== 1 ? 's' : '') . ' al formulario');
        }

        $path_destino = $this->getPathNAS();
        if (!is_dir($path_destino)) {
            if (!mkdir($path_destino, 0777, true)) {
                throw new Exception('No se pudo crear la ruta de destino para los ' .
                'ficheros adjuntos al requerimiento');
            }
        }

        foreach ($ficheros_validos as $fichero_valido) {

            $fichero = Utils::sanitizeNameFile(basename($fichero_valido['name']), 240);

            if (move_uploaded_file($fichero_valido['tmp_name'], $path_destino . $fichero)) {
                // guardamos en la base de datos plantillas
                $repositorio = new PlantillasRepository();
                $repositorio->save($fichero);
                return true;
            } else {
                throw new Exception('No se pudo guardar el fichero "' . $fichero . '"');
            }
        }
        return false;
    }

    public function getTamMaxInMb() {
        return number_format(round(self::TAM_MAX_FICHERO / self::BYTES_MB, 2), 2) . ' MB';
    }

    private function getPathNAS() {
        return $this->app->config('uploaddir_templates');
    }

}
