<?php

namespace src\Library\View;

use Slim\Slim;

class View {

    protected $data;
    protected $templatesDirectory;
    protected $app;

    public function __construct(Slim $app) {
        $this->templatesDirectory = $app->config('templates');
        $this->data = new \Slim\Helper\Set();
        $this->app = $app;
    }

    public function has($key) {
        return $this->data->has($key);
    }

    public function get($key) {
        return $this->data->get($key);
    }


    public function set($key, $value) {
        $this->data->set($key, $value);
    }

    public function keep($key, \Closure $value) {
        $this->data->keep($key, $value);
    }

    public function all() {
        return $this->data->all();
    }

    public function replace(array $data) {
        $this->data->replace($data);
    }


    public function clear() {
        $this->data->clear();
    }

    public function getData($key = null) {
        if (!is_null($key)) {
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }

        return $this->data->all();
    }

    public function setData() {
        $args = func_get_args();
        if (count($args) === 1 && is_array($args[0])) {
            $this->data->replace($args[0]);
        } elseif (count($args) === 2) {
            // Ensure original behavior is maintained. DO NOT invoke stored Closures.
            if (is_object($args[1]) && method_exists($args[1], '__invoke')) {
                $this->data->set($args[0], $this->data->protect($args[1]));
            } else {
                $this->data->set($args[0], $args[1]);
            }
        } else {
            throw new \InvalidArgumentException('Cannot set View data with provided arguments. Usage: `View::setData( $key, $value );` or `View::setData([ key => value, ... ]);`');
        }
    }

    public function appendData($data) {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Cannot append view data. Expected array argument.');
        }
        $this->data->replace($data);
    }

    public function setTemplatesDirectory($directory) {
        $this->templatesDirectory = rtrim($directory, DIRECTORY_SEPARATOR);
    }


    public function getTemplatesDirectory() {
        return $this->templatesDirectory;
    }


    public function getTemplatePathname($file) {
        return $this->templatesDirectory . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR) .'.php';
    }

    public function display($template, $data = null) {
        echo $this->fetch($template, $data);
    }

    public function fetch($template, $data = null) {
        return $this->render($template, $data);
    }

    public function render($template, $data = null) {
        
        $templatePathname = $this->getTemplatePathname($template);
        if (!is_file($templatePathname)) {
            throw new \RuntimeException("View cannot render `$templatePathname` because the template does not exist");
        }
        $templatePart = new ViewPart($this->app);
        $app = $this->app;
        $data = array_merge($this->data->all(), (array) $data);
        //extract($data);
        ob_start();
        
        require $this->getTemplatePathname('layout');
       // require $templatePathname;
       // require $this->getTemplatePathname('footer');
        return ob_get_clean();
    }

}
