<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/03
 * Time: 0:22
 */

namespace Chatbox\Album\HTTP\Route;

use Chatbox\Album\Album;
use Chatbox\PHPUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class Upload {

    function __construct()
    {
    }

    public function actionList(){
        return JsonResponse::create(["hogehoge"=>"pipyopiyo"]);
    }

	public function actionPost(Request $request){
		$originName = $request->get("file");
		$fileData = PHPUtil::dataUriToBinary($request->get("data"));

		$album = new Album();
		$image = $album->upload($originName,$fileData);
		$image->save();

		return JsonResponse::create([
			"hoge"=>"hoge",
		]);
	}

	public function actionFile(){

	}


} 