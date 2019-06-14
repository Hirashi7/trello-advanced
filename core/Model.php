<?php

namespace Core;

use Card;
use Interfaces\ModelInterface;
use JsonMapper;
use PHPUnit\Framework\Exception;

abstract class Model implements ModelInterface
{
    protected $mapper;
    protected $db;
    public function __construct() {
        $this->mapper = new JsonMapper();
        $this->mapper->bStrictNullTypes = false;
        $this->db = new \DbConnection();
    }

    protected static function makeRequest($url, $data = null, $method = 'GET') {
        $key = API_KEY;
        $token = API_TOKEN;
        $url = "https://api.trello.com/1/{$url}?key={$key}&token={$token}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($data != null && $method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if($data != null && $method == 'POST') {
            $data = json_encode($data);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
            );
        }

        if($method == "DELETE") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        $request = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $request = json_decode($request);
        return ($httpcode>=200 && $httpcode<300) ? $request : false;
    }

    public static function get($requestUrl, $class = null) {
        if($class == null) $class = static::class;
        $mapper = new JsonMapper();
        $mapper->bStrictNullTypes = false;


        $request = self::makeRequest($requestUrl);

        if(!$request) {
            return null;
        }
        $items = [];

        if(is_array($request)){
            foreach ($request as $item) {
                $items[] = $mapper->map($item, new $class());
            }
            return $items;
        }
        
        return $mapper->map($request, new $class());
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

    // public static function map($data) {
    //     $class = static::class;
    //     $mapper = new JsonMapper();
    //     $mapper->bStrictNullTypes = false;

    //     if($data == null|| empty($data)) {
    //         throw new Exception('Invalid data');
    //     }
    //     if(is_string($data)) {
    //         $data = json_encode($data);
    //     }
    //     return $mapper->map((object)$data, new $class());
    // }

}