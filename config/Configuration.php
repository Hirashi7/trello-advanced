<?php

namespace Config;

class Configuration
{
    /**
     * @var array
     * Global app settings
     */
    public static $settings = [
        'app_name' => 'MyApp',
        'lang_iso' => 'pl',
        'api' => true
    ];


    /**
     * @var array
     * Key is resource, value decides which resource will be loaded in head
     */
    public static $assets = [
        'css' => [
            'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' => true,
            '/views/_layout/assets/style.css' => true,
        ],
        'js' => [
            'https://code.jquery.com/jquery-3.3.1.slim.min.js' => false,
            'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' => false,
            'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' => false
        ],
    ];
}