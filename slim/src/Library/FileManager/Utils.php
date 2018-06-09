<?php

namespace src\Library\FileManager;

class Utils {

    public static function sanitizeNameFile($name, $max_length_name = 255, $removePoints = false) {
        $correspondencias = array(
            'Š' => 'S', 'š' => 's',
            'Ž' => 'Z', 'ž' => 'z',
            'Ç' => 'C', 'ç' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ð' => 'O',
            'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ð' => 'o',
            'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'Ñ' => 'N', 'ñ' => 'n',
            'Ý' => 'Y', 'Ÿ' => 'Y', 'ý' => 'y', 'ÿ' => 'y',
            'Þ' => 'B', 'þ' => 'b',
            'ß' => 'Ss',
        );

        $name = trim($name);
        $name = strtr($name, $correspondencias);
        $name = preg_replace('/[^\w\s\d\-\_\.]/', '', $name);
        $name = preg_replace('/\s+/', '-', $name);
        $name = preg_replace('/\_+/', '-', $name);

        if ($removePoints) {
            $name = preg_replace('/\.+/', '-', $name);
        }

        $name = preg_replace('/([\-\.])\\1+/', '$1', $name);
        $name = strtolower($name);
        $diferencia = $max_length_name - strlen($name);

        if ($diferencia < 0) {
            $index_punto = strrpos($name, '.');

            if ($index_punto !== false) {
                $aux_name = substr($name, 0, $index_punto);
                $aux_extension = substr($name, $index_punto);
                $name = substr($aux_name, 0, $diferencia) . $aux_extension;
            } else {
                $name = substr($name, 0, $max_length_name);
            }
        }

        return $name;
    }

    public static function getExtension($mime) {
        switch ($mime) {
            case 'application/vnd.ms-powerpoint': return '.pps';
            case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow': return '.ppsx';
            case 'application/vnd.ms-powerpoint': return '.ppt';
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation': return '.pptx';
            case 'application/vnd.ms-powerpoint': return '.ppz';
            case 'application/msword': return '.doc';
            case 'application/vnd.msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document': return '.docx';
            case 'application/oda': return '.oda';
            case 'application/ogg': return '.ogg';
            case 'application/ogg': return '.ogm';
            case 'application/pdf': return '.pdf';
            case 'application/pgp': return '.pgp';
            case 'application/postscript': return '.ps';
            case 'application/pro_eng': return '.prt';
            case 'application/rtf': return '.rtf';
            case 'application/vnd.ms-excel': return '.xlc';
            case 'application/vnd.ms-excel': return '.xll';
            case 'application/vnd.ms-excel': return '.xlm';
            case 'application/vnd.ms-excel': return '.xlw';
            case 'application/vnd.ms-excel': return '.xls';
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': return '.xlsx';
            case 'application/x-gunzip': return '.gz';
            case 'application/x-latex': return '.latex';
            case 'application/x-rar-compressed': return '.rar';
            case 'application/x-tar-gz': return '.tgz';
            case 'application/x-tar': return '.tar';
            case 'application/x-zip-compressed': return '.zip';
            case 'image/bmp': return '.bmp';
            case 'image/gif': return '.gif';
            case 'image/jpeg': return '.jpg';
            case 'image/png': return '.png';
            case 'image/tiff': return '.tiff';
            case 'image/x-portable-anymap': return '.pnm';
            case 'image/x-portable-bitmap': return '.pbm';
            case 'image/x-portable-graymap': return '.pgm';
            case 'image/x-portable-pixmap': return '.ppm';
            case 'image/x-xbitmap': return '.xbm';
            case 'image/x-xpixmap': return '.xpm';
            case 'text/html': return '.html';
            case 'text/plain': return '.txt';
            case 'text/sgml': return '.sgml';
            case 'text/xml': return '.xml';
            default: return '';
        }
    }

    /**
     * @param string $path
     * @return string
     */
    public static function getMime($path) {
        $exist = file_exists($path);

        if (!$exist || ($exist && !is_file($path))) {
            return NULL;
        }

        if (extension_loaded('fileinfo')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            return $finfo->file($path);
        } else {
            return mime_content_type($path);
        }
    }

    public static function addExtension($name, $mime) {
        $match = preg_match('/\.[A-Za-z0-9]{1,6}$/', $name);

        if ($match === 0) {
            $extension = self::getExtension($mime);
            $name = $name . $extension;
        }

        return $name;
    }

    public static function removeDir($dirPath) {
        if (!file_exists($dirPath)) {
            return;
        }

        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException($dirPath . ' debe ser un directorio');
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }

        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::removeDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}
