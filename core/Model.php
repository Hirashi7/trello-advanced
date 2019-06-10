<?php

namespace Core;

use Interfaces\ModelInterface;
use JsonMapper;

abstract class Model implements ModelInterface
{
    protected $mapper;
    public function __construct() {
        $this->mapper = new JsonMapper();
    }
    protected function makeRequest($url) {
        $key = API_KEY;
        $token = API_TOKEN;
        $url = "https://api.trello.com/1/{$url}?key={$key}&token={$token}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $data = json_decode($data);
        return ($httpcode>=200 && $httpcode<300) ? $data : false;
    }
}