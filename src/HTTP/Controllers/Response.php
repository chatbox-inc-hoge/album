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

use Silex\ControllerProviderInterface;

class Response extends Base{

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

        $controllers->get("/redirect/{category}/{originName}",[$this,"actionRedirect"]);
        $controllers->get("/src/{category}/{originName}",[$this,"actionRedirect"]);
        $controllers->get("/gd/{category}/{originName}",[$this,"actionGd"]);
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
			"origin_name" => $id
		]);
	}


    public function actionRedirect(API $api,$category,$originName){
        try{
            $image = $this->getImage($api,$category,$originName);
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
    }

	public function actionGd(API $api,$category,$originName){
		try{
			$image = $this->getImage($api,$category,$originName);
			if($image){
				$im = imagecreatefromstring($image->getEloquent()->data->data);
				header('Content-Type: image/png');
				imagepng($im);
				imagedestroy($im);
			}else{
				return JsonStatusResponse::bad([
					"category" => $category,
					"origin_name" => $originName
				]);
			}
		}catch (\Exception $e){
			return JsonStatusResponse::error($e);
		}
	}

} 