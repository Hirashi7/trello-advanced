<?php

namespace Core;

use Card;
use Interfaces\ModelInterface;
use JsonMapper;

abstract class Model implements ModelInterface
{
    protected $mapper;
    public function __construct() {
        $this->mapper = new JsonMapper();
        $this->mapper->bStrictNullTypes = false;
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

    protected function get($requestUrl, $class): ?array {
        $request = $this->makeRequest($requestUrl);

        if(!$request) {
            return null;
        }
        $items = [];
        foreach ($request as $item) {
            $items[] = $this->mapper->map($item, new $class());
        }

        return $items;
    }

    protected static function filterBy(array $data, array $args, $resultCount = 1): ?array {
        $filtered = array_filter($data, function($item) use ($args) {
            $match = true;
            foreach ($args as $key => $value) {
                if($item->$key != $value) {
                    $match = false;
                }
            }
            return $match;
        });

        if(sizeof($filtered) === 0) {
            return null;
        }

        if($resultCount !== 0) {
            $filtered = array_slice($filtered, 0, $resultCount);
        }

        return $filtered;
    }

}