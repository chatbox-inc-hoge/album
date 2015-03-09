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


class Book implements ControllerProviderInterface{

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
//        $controllers->get("/list/{category}/",[$this,"actionInfo"]);//deprecated
        $controllers->get("/list/",[$this,"actionList"]);
        $controllers->get("/info/{categoryName}",[$this,"actionInfo"]);
        return $controllers;
    }

	/**
	 * 利用可能なカテゴリの一覧を取得
	 * @param API $api
	 * @param $category
	 * @return static
	 */
	public function actionList(API $api){
		$list = $api->getAlbum()->image()->getCategories();
		return JsonStatusResponse::ok([
			"list" => $list
		]);
    }
	/**
	 * 指定したカテゴリの画像一覧を取得
	 * @param API $api
	 * @param $category
	 * @return static
	 */
	public function actionInfo(API $api,$categoryName){
        $imageList = $api->getAlbum()->image()->getByCategory($categoryName);
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