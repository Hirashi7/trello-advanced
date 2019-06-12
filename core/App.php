<?php

use Config\Configuration;

class App
{
    /**
     * @var DbConnectionInterface
     */
    public $db_connection;

    /**
     * @var IdentityServiceInterface
     */
    public $identity;
    
    public $messages;

    public $lang_iso;

    public $name;

    public function __construct(
        DbConnectionInterface $db_connection = null, 
        IdentityServiceInterface $identity_service = null,
        MessagesInterface $messages = null)
    {
        // Dependency injection
        $this->db_connection = $db_connection;
        $this->identity = $identity_service;
        $this->messages = $messages;

        // Dependencies setup
        if($this->identity !== null) {
            $this->identity->setDatabaseConnection($this->db_connection);
        }

        // Globals set
        $this->lang_iso = Configuration::$settings['lang_iso'];
        $this->name = Configuration::$settings['app_name'];
    }
}