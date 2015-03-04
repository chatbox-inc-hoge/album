<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/03/01
 * Time: 11:39
 */

return [
    "silane" => [
        "hoge"=>"piyo",
        "silex"=>[
            "debug"=>true
        ],
        "providers" => [
            new \Chatbox\Silane\Providers\RestErrorHandlerProvider(),
        ],
        "controllers" => [
            "/upload" => new \Chatbox\Album\HTTP\Controllers\Upload(),
            "/photo"  => new \Chatbox\Album\HTTP\Controllers\Photo(),
            "/image"  => new \Chatbox\Album\HTTP\Controllers\Image(),
            "/i"      => new \Chatbox\Album\HTTP\Controllers\Redirect(),
        ],

    ]
];