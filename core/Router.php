<?php

class Router implements RouterInterface
{
    /**
     * @var App
     */
    private $_app;

    /**
     * @param App $app
     */
    public function setAppInstance(App $app)
    {
        $this->_app = $app;
    }

    /**
     * Routes to proper controller and action
     * @param string $controller_class
     * @param string $action_name
     * @param null $param
     */
    public function redirect(string $controller_class, string $action_name = 'indexAction', $param = null){

        if(!class_exists($controller_class)){
            if(DEBUG) {
                throw new Exception("Controller '{$controller_class}' not exists!");
            }
            $this->redirect404();
            return;
        }

        $controller = new $controller_class($this->_app);

        if(!method_exists($controller, $action_name)){
            if(DEBUG) {
                throw new Exception("Action '{$action_name}' not exists!");
            }
            $this->redirect404();

            return;
        }

        $controller->$action_name($param);
        return;

    }

    /**
     * Redirects to home action
     */
    public function redirectHome(): void
    {
        self::redirect('HomeController','indexAction');
    }

    /**
     * Redirects to 404 action
     */
    public function redirect404(): void {
        header('location: /views/error/error404.php');
        exit;
    }
}