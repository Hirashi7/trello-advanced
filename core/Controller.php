<?php

namespace Core;

use App;
use Config\Configuration;
use ControllerInterface;
use Exception;


abstract class Controller implements ControllerInterface
{
    /**
     * @var App
     */
    public $app;
    public $db;
    public $messages;

    public $data;

    /**
     * @var Controller view name
     */
    public $name;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->db = $app->db_connection;
        $this->messages = $app->messages;
        if(isset($_POST) && sizeof($_POST) > 0){
            $_POST = $this->filterArray($_POST);
        }
    }

    /**
     * Prepare layout head
     * @return string
     */
    public function head(): string {
        $css = array_filter(Configuration::$assets['css'], function($item){
            return $item;
        });

        $js = array_filter(Configuration::$assets['js'], function($item){
            return $item;
        });

        $html = '';
        foreach ($css as $path => $value) {
            $html .= "<link rel=\"stylesheet\" href=\"{$path}\">\n";
        }
        foreach ($js as $path => $value) {
            $html .= "<script src=\"{$path}\"></script>\n";
        }
        return $html;
    }

    /**
     * Prepare layout footer
     * @return string
     */
    public function footer(): string {
        $css = array_filter(Configuration::$assets['css'], function($item){
            return !$item;
        });

        $js = array_filter(Configuration::$assets['js'], function($item){
            return !$item;
        });

        $html = '';
        foreach ($css as $path => $value) {
            $html .= "<link rel=\"stylesheet\" href=\"{$path}\">\n";
        }
        foreach ($js as $path => $value) {
            $html .= "<script src=\"{$path}\"></script>\n";
        }
        \Messages::clear();
        return $html;
    }

    /**
     * @param string $view_name
     * @param null $data
     * @throws Exception
     */
    protected function render(string $view_name, $data = null): void {
        if($this->name === null || empty($this->name)){
            $this->name = strtolower(str_replace('Controller','', get_called_class()));
        }
        $file_path = VIEWS_DIR . "/{$this->name}/{$view_name}.php";

        if(!file_exists($file_path)){
            throw new Exception("No file {$file_path}");
            return;
        }
        $this->data = $data;
        require_once VIEWS_DIR . '/_layout/header.php';
        require_once $file_path;
        require_once VIEWS_DIR . '/_layout/footer.php';
    }

    protected function filterField($data) {
        if(is_array($data)) {
            return $this->filterArray($data);
        }
        $data = trim(htmlspecialchars($data));
        return $data;
    }
    protected function filterArray($data) {
        foreach ($data as $key => $value) {
            $data[$key] = $this->filterField($value);
        }
        return $data;
    }

}