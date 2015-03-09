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

class Image extends Base{

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

        $controllers->post("/delete/{category}/{id}",[$this,"actionDelete"]);
        return $controllers;
    }

	/**
	 * 画像の取得ユーティリティ
	 * @param API $api
	 * @param $category
	 * @param $id
	 * @return \Chatbox\Album\Services\Image
	 */
	protected function getImage(API $api,$category,$id){
		return $api->getAlbum()->image()->fetch([
			"category" => $category,
			"hashed_name" => $id
		]);
	}

	/**
	 * 指定した画像を削除
	 * @param API $api
	 * @param $category
	 * @param $id
	 * @return static
	 */
	public function actionDelete(API $api,$category,$id){
        try{
            $image = $this->getImage($api,$category,$id);
            if($image){
                $image->delete();
            }else{
                return JsonStatusResponse::bad();
            }
        }catch (\Exception $e){
            return JsonStatusResponse::error($e);
        }
        return JsonStatusResponse::ok([]);
    }

} 