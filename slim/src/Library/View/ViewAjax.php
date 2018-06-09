<?php

namespace src\Library\View;

class ViewAjax extends View {

    public function render($template, $data = null) {
        $templatePathname = $this->getTemplatePathname($template) . '.php';
        if (!is_file($templatePathname)) {
            throw new \RuntimeException("View cannot render `$templatePathname` because the template does not exist");
        }
        $app = $this->app;
        $data = array_merge($this->data->all(), (array) $data);
        extract($data);
        require $templatePathname;
    }

}
