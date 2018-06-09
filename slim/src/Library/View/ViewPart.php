<?php

namespace src\Library\View;

class ViewPart extends View {

    public function renderPart($template, $data = null) {
        $template = $this->getTemplatePathname($template);
        if (!is_file($template)) {
            echo ("View cannot render `$template` because the template does not exist");
        }
         $data = array_merge($this->data->all(), (array) $data);
        extract($data);
        $templatePart = new ViewPart($this->app);
        $app = $this->app;
        $data = array_merge($this->data->all(), (array) $data);
        require $template;
    }

}
