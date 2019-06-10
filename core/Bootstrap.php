<?php

use Config\Configuration;

class Bootstrap {

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var App instance
     */
    private $app;

    public function __construct(App $app, RouterInterface $router)
    {
        $this->router = $router;
        $this->app = $app;
        $this->router->setAppInstance($this->app);
        $this->init();
    }

    /**
     * Handles routing
     */
    private function init()
    {
        if(!isset($_SERVER['REDIRECT_URL'])) {
            $this->router->redirectHome();
            return;
        }

        $request = explode('/',$_SERVER['REDIRECT_URL']);

        $request = array_filter($request, function($item) {
            if ($item !== "") {
                return true;
            }
            return false;
        });

        $request = array_values($request);

        $prefix = '';
        $actionSuffix = 'Action';
        $index = 0;

        if(Configuration::$settings['api']
            && isset($request[0])
            && $request[0] == 'api') {
            $prefix = 'Api';
            $actionSuffix = '';
            $index = 1;
        }
        switch (sizeof($request)){
            case 1 + $index:
                $this->router->redirect($prefix . ucfirst($request[$index]) . 'Controller', 'index' . $actionSuffix);
                break;
            case 2 + $index:
                $this->router->redirect($prefix . ucfirst($request[$index]) . 'Controller', $request[$index + 1] . $actionSuffix);
                break;
            default:
                $this->router->redirect($prefix . ucfirst($request[$index]) . 'Controller', $request[$index + 1] . $actionSuffix, $request[$index + 2]);
                break;

        }
    }
}

