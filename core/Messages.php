<?php 

class Messages implements MessagesInterface {
    public function __construct()
    {
        if(!isset($_SESSION['messages'])){
            $_SESSION['messages'] = [];
        }
    }
    public function push($string, $type = 'info') {
        $_SESSION['messages'][$type][] = $string;
    }
    public static function display() {
        $html = '';
        foreach ($_SESSION['messages'] as $key => $messages) {
            $html .= "<div class='alert alert-{$key}'>";
            $html .= "<ul class='list-unstyled' style='margin-bottom: 0;'>";
            foreach ($messages as $message) {
                $html .= "<li>{$message}</li>";
            }
            $html .= "</ul>";
            $html .= "</div>";
        }
        return $html;
    }
    public static function clear() {
        unset($_SESSION['messages']);
    }
}