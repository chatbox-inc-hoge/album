<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/03/01
 * Time: 12:56
 */

namespace Chatbox\Album\HTTP\Controllers;

use Chatbox\Album\HTTP\API;
use Chatbox\Silane\Response\JsonStatusResponse;
use Chatbox\PHPUtil;

use Chatbox\Input;
use Silex\ControllerProviderInterface;

class Upload extends Base{

    /**
     * @var Input
     */
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

        $controllers->post("/data",[$this,"actionPost"]);

        return $controllers;
    }


	/**
	 * file
	 * data
	 *
	 * @param API $api
	 * @return static
	 */
	public function actionPost(API $api){
        try{
            $album = $api->getAlbum();
            $originName = $this->getInput()->get("file");
            $fileData = PHPUtil::dataUriToBinary($this->input->get("data"));

            $upload = $album->upload()->dumpTmpFile($originName,$fileData);
//        var_dump($originName);exit;

            $newImage = $album->image()->create("common","comment",$upload);
        }catch(\Exception $e){
            return JsonStatusResponse::error($e);
        }
        return JsonStatusResponse::ok([
            "hoge"=>"hoge",
        ]);
    }



} 