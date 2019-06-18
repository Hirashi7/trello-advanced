<?php

namespace Core;

use App;
use Config\Configuration;
use ControllerInterface;
use Exception;


abstract class ApiController implements ControllerInterface
{
    /**
     * @var App
     */
    public $app;
    public $db;

    /**
     * @var Controller view name
     */
    public $name;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->db = $app->db_connection;

        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    /**
     * @param string $data
     */
    protected function success($data = '') {
        http_response_code(200);
        echo json_encode($data);
    }

    /**
     * Set 404 http request
     */
    protected function notFound() {
        http_response_code(404);
    }

    /**
     * Set error http request
     */
    protected function error() {
        http_response_code(400);
    }


}