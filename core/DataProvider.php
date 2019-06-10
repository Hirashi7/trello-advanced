<?php


namespace Core;


class DataProvider
{
    public $data = null;

    /**
     * DataProvider constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

}