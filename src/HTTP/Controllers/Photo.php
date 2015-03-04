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
use Silex\ControllerProviderInterface;


class Photo implements ControllerProviderInterface{

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
        $controllers->get("/list/{category}/",[$this,"actionList"]);
        return $controllers;
    }

    public function actionList(API $api,$category){
        $imageList = $api->getAlbum()->image()->getByCategory($category);
        return JsonStatusResponse::ok([
            "list"=>$imageList,
            "query"=>\Chatbox\PHPUtil::getEloquent()->getQueryLog()
        ]);
    }

    public function actionPost(API $api,Request $request){
        $album = $api->getAlbum();
        $originName = $request->get("file");
        $fileData = PHPUtil::dataUriToBinary($request->get("data"));

        $upload = $album->upload();
        $upload->dumpTmpFile($originName,$fileData);

        $image = $album->image();
        $newImage = $image->create("common","comment",$upload);

        return JsonResponse::create([
            "hoge"=>"hoge",
        ]);
    }



} 