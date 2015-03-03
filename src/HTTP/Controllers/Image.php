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

class Image implements \Silex\Api\ControllerProviderInterface{

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
        $controllers->post("/delete/{category}/{id}",[$this,"actionDelete"]);
        return $controllers;
    }

    public function actionDelete(API $api,$category,$id){
        try{
            $image = $api->getAlbum()->image()->fetch([
                "category" => $category,
                "hashed_name" => $id
            ]);
            if($image){
                $image->delete();
            }else{
                return JsonStatusResponse::bad();
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