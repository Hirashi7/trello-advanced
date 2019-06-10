<?php

namespace Core;

use DbConnection;
use ModelInterface;

abstract class Model implements ModelInterface
{
    protected $_db;

    public function __construct()
    {
        $this->_db = new DbConnection();
    }
}