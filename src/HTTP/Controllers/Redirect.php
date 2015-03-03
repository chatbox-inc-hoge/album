<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/03/01
 * Time: 12:56
 */

namespace Chatbox\Album\HTTP\Controllers;

use Chatbox\Album\HTTP\API;
use Chatbox\Input;
use Chatbox\Silane\Response\JsonStatusResponse;
use Chatbox\HTTP;

class Redirect implements \Silex\Api\ControllerProviderInterface{

    protected $input;
    /**
     * Returns routes to connect to the given application.
     *
     * @param \Silex\Application $app An Application instance
     *
     * @return \Silex\ControllerCollection A ControllerCollection instance
     */
    public function connect(\Silex\Application $app)
    {
        $controllers = $app["controllers_factory"];

        $this->input = Input::load("json");
        $controllers->get("/redirect/{category}/{originName}",[$this,"actionRedirect"]);
        $controllers->get("/src/{category}/{originName}",[$this,"actionRedirect"]);
        $controllers->get("/info/{category}/{originName}",[$this,"actionInfo"]);
        return $controllers;
    }

    public function actionRedirect(API $api,$category,$originName){
        try{
            $image = $api->getAlbum()->image()->fetch([
                "category" => $category,
                "origin_name" => $originName
            ]);
            if($image){
                HTTP::redirect($image->getUrl());
                exit;
            }else{
                return JsonStatusResponse::bad([
                    "category" => $category,
                    "origin_name" => $originName
                ]);
            }
        }catch (\Exception $e){
            return JsonStatusResponse::error($e);
        }
        return JsonStatusResponse::ok([
//            "list"=>$imageList,
            "query"=>\Chatbox\PHPUtil::getEloquent()->getQueryLog()
        ]);
    }

} 