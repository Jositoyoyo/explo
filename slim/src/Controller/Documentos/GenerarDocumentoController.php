<?php

namespace src\Controller\Documentos;

use src\Controller\Controller;
use PhpOffice\PhpWord\TemplateProcessor;

class GenerarDocumentoController extends Controller {

    public function __construct($app) {
        parent::__construct($app);
    }

    public function generarDocumento() {
        
        if ($this->app->request->isPost()) {
            
            $templateWord = new TemplateProcessor('/var/www/html/trabajo/explosivos/branches/version3.0/slim/src/Controller/Documentos/plantilla.docx');
            $templateWord->setValue('nombre', 'LAMAS RAPADOIRO, nº62');
            $templateWord->setValue('explotacion','LG. DE LAMAS');
            $templateWord->setValue('fecha', date('Y-d-m'));
            $templateWord->saveAs('Documento02.docx');

            header("Content-Disposition: attachment; filename=Documento02.docx; charset=iso-8859-1");
            echo file_get_contents('Documento02.docx');
            
        }
    }

}
