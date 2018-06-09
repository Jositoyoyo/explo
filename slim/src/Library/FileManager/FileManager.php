<?php

namespace src\Library\FileManager;

class FileManager {

    const NS_BACKEND = 'backend_session';
    const NS_FRONTEND = 'atlantis';

    const T_ENVIOS = 'envios';

    const REMOVE_RESULT_ID_NOT_EXISTS = 1;
    const REMOVE_RESULT_OK_FROM_SESSION = 2;
    const REMOVE_RESULT_OK_FROM_SYSTEM = 3;

    protected $config;
    protected $session;

    protected $namespaceSession;
    protected $varSession;

    public function __construct($app) {
        $this->config = $app;
    }

    public function getFicheroSubido($name) {
        /*if (NULL === $name || '' === $name) {
            throw new Exception('Error subiendo archivo. Faltan parametros');
        }

        if (!isset($_FILES[$name])) {
            throw new Exception('Error subiendo archivo. No se ha recibido el fichero');
        }
*/
        $file = $_FILES[$name];

        if (!empty($file['error'])) {
            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;

                case UPLOAD_ERR_INI_SIZE:
                    throw new Exception('El tamaño del archivo a subir es superior al limite permitido por configuración');
                    break;

                case UPLOAD_ERR_FORM_SIZE:
                    throw new Exception('El tamaño del archivo a subir es superior al limite permitido indicado en el formulario');
                    break;

                case UPLOAD_ERR_PARTIAL:
                    throw new Exception('El archivo solo se ha subido parcialmente');
                    break;

                case UPLOAD_ERR_NO_FILE:
                    throw new Exception('No se ha subido ningun archivo');
                    break;

                case UPLOAD_ERR_NO_TMP_DIR:
                    throw new Exception('Carpeta temporal inaccesible. Pruebe a intentarlo tras unos minutos');
                    break;

                case UPLOAD_ERR_CANT_WRITE:
                    throw new Exception('Fallo al escribir los adjuntos en el servidor. Pruebe a intentarlo de nuevo tras unos minutos');
                    break;

                case UPLOAD_ERR_EXTENSION:
                    throw new Exception('Una extensión de la aplicación detuvo la subida de ficheros. Pruebe a intentarlo de nuevo tras unos minutos');
                    break;

                default:
                    throw new Exception('Error desconocido. Vuelva a intentarlo pasado unos minutos');
                    break;
            }
        }

        if (NULL === $file['tmp_name'] || '' === $file['tmp_name'] || 'none' === $file['tmp_name']) {
            throw new Exception('Error subiendo archivo. No se ha detectado el nombre temporal del archivo');
        }

        return new FicheroUpload($file);
    }

    /**
     *
     * @param Map_Fichero_Upload $file
     * @param string $destiny
     * @param int $maxLengthFileName
     * @param boolean $toTempPath
     * @return Map_Fichero_ResultMove
     */
    public function moveToPath($file, $destiny, $maxLengthFileName = 64, $toTempPath = false) {
        $fileName = Map_Utils::sanitizeNameFile(
            pathinfo($file->getName(), PATHINFO_FILENAME),
            $maxLengthFileName,
            true
        );

        if ($toTempPath) {
            $fileNameTmp = $fileName.date('YmdHis');
            $path = $this->config->filesystem->uploaddir.'/Temp/'.$destiny;
        } else {
            $fileNameTmp = $fileName;
            $path = $this->config->filesystem->uploaddir.$destiny;
        }

        if (substr($path, -1) !== '/') {
            $path .= '/';
        }
        
        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                throw new Exception('No se ha podido crear el path');
            }
        }

        if (!move_uploaded_file($file->getTmpName(), $path.$fileNameTmp)) {
            throw new Exception('Error al mover el fichero: '.$file->getTmpName());
        }

        $result = new Map_Fichero_ResultMove();
        $result->setName($fileName);
        $result->setSize($file->getSize());
        $result->setHash(md5(file_get_contents($path.$fileNameTmp)));
        $result->setPath($path.$fileNameTmp);
        $result->setType($file->getType());
        return $result;
    }

    /**
     *
     * @param Map_Fichero_Upload $file
     * @param string $destiny
     * @param int $maxLengthFileName
     * @return Map_Fichero_ResultMove
     */
    public function moveToTempPath($file, $destiny, $maxLengthFileName = 64) {
        return $this->moveToPath($file, $destiny, $maxLengthFileName, true);
    }

    /**
     *
     * @param string $ficheroOrigen
     * @param string $dirDestino
     * @param string $nombreEnDestino
     * @return boolean
     */
    public function copyFileToPath($ficheroOrigen, $dirDestino, $nombreEnDestino) {
        $existe = file_exists($ficheroOrigen);

        if (!$existe || ($existe && !is_file($ficheroOrigen))) {
            throw new Exception('El archivo a copiar no es un fichero');
        }

        if (!$dirDestino) {
            throw new Exception('El directorio de destino no es válido');
        }

        if (substr($dirDestino, -1) !== '/') {
            $dirDestino .= '/';
        }

        if (!is_dir($dirDestino)) {
            if (!mkdir($dirDestino, 0777, true)) {
                throw new Exception('No se puede crear la ruta de destino realizar la operación de copia');
            }
        }

        return copy($ficheroOrigen, $dirDestino.$nombreEnDestino);
    }

    /**
     *
     * @param string $id
     * @param Map_Fichero_ResultMove $result
     */
    public function saveOnSession($id, $result, $extra = array()) {
        $session = new Zend_Session_Namespace($this->namespaceSession);

        if (!isset($session->{$this->varSession})) {
            $session->{$this->varSession} = array();
        }
        
        $session->{$this->varSession}[$id] = new stdClass();
        $session->{$this->varSession}[$id]->path = $result->getPath();
        $session->{$this->varSession}[$id]->file_name = $result->getName();
        $session->{$this->varSession}[$id]->hash = $result->getHash();
        $session->{$this->varSession}[$id]->mime = $result->getType();

        foreach ($extra as $key => $value) {
            $session->{$this->varSession}[$id]->{$key} = $value;
        }
    }

    /**
     *
     * @param string $id
     * @return int
     */
    public function removeFromSession($id) {
        $session = new Zend_Session_Namespace($this->namespaceSession);

        if (isset($session->{$this->varSession}) && isset($session->{$this->varSession}[$id])) {
            $path = $session->{$this->varSession}[$id]->path;
            unset($session->{$this->varSession}[$id]);

            if (file_exists($path) && is_file($path)) {
                unlink($path);
                return self::REMOVE_RESULT_OK_FROM_SYSTEM;
            } else {
                return self::REMOVE_RESULT_OK_FROM_SESSION;
            }
        }

        return self::REMOVE_RESULT_ID_NOT_EXISTS;
    }

    /**
     *
     *
     */
    public function removeAllFromSession() {
        $session = new Zend_Session_Namespace($this->namespaceSession);

        if (isset($session->{$this->varSession}) && is_array($session->{$this->varSession})) {
            foreach ($session->{$this->varSession} as $id => $file) {
                if (file_exists($file->path) && is_file($file->path)) {
                    unlink($file->path);
                }
            }

            $session->{$this->varSession} = array();
        }
    }

    public function removeTempPath($path) {
        $realPath = $this->config->filesystem->uploaddir.'/Temp/'.$path;
        return rmdir($realPath);
    }

    /**
     *
     * @param string $tablr
     * @return boolean
     */
    public static function isValidTable($table) {
        return in_array(
            $table,
            array(
                self::T_ENVIOS,
            )
        );
    }
}