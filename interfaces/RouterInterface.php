<?php


interface RouterInterface
{
    /**
     * @param string $controller_class
     * @param string $action_name
     * @param null $param
     * @return mixed
     */
    function redirect(string $controller_class, string $action_name, $param = null);

    /**
     * @return mixed
     */
    function redirectHome();

    /**
     * @return mixed
     */
    function redirect404();

    /**
     * @param App $app
     * @return mixed
     */
    function setAppInstance(App $app);
}