<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/03
 * Time: 0:22
 */

namespace Chatbox\Album\HTTP\Route;

use Chatbox\Album\Album;
use Symfony\Component\HttpFoundation\JsonResponse;

class Photo {

    function __construct()
    {
    }

	public function actionShow($category,$originName){

		$album = new Album();
		$image = $album->getOne($category,$originName);
		$album->redirect($image);
		exit;
	}

    public function actionList($category){

		$album = new Album();
	    $book = $album->book($category);
        return JsonResponse::create([
	        "list" => $book
        ]);
    }



} 