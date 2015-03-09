<?php
namespace Chatbox\Album\HTTP\Controllers;

use Chatbox\Input;
use Chatbox\PHPUtil;
use Silex\Application;
use Silex\ControllerProviderInterface;

use Chatbox\Silane\Response\JsonStatusResponse;

use Chatbox\Album\HTTP\API;

/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2015/02/10
 * Time: 19:48
 */

class Archive extends Base{

	/**
	 * @var Input
	 */

	public function connect(Application $app)
	{
		$controllers = $app['controllers_factory'];

		$controllers->post('/category/list', [$this,"postCategoryList"]);
		$controllers->post('/category/info', [$this,"postCategoryInfo"]);
		$controllers->post('/upload', [$this,"postUpload"]);

		return $controllers;
	}

	/**
	 * ZIP アップロードを任せる。
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function postUpload(API $api){
		if(!$category = $this->getInput()->get("category")){
			return JsonStatusResponse::bad([
				"msg"=>"category name not supplied"
			]);
		}
		$categories = $api->getAlbum()->image()->getCategories();
		if(isset($categories[$category])){
			return JsonStatusResponse::bad([
				"msg"=>"cant override. the category name is already used."
			]);
		}

		$data = $this->getInput()->get("data");
		$data = PHPUtil::dataUriToBinary($data);

		$zip = $api->getAlbum()->zip()->open($data);
		if(true || $count = $zip->count()){
			$zip->extract($category);
			$categoryList = $api->getAlbum()->image()->getByCategory($category);
			return JsonStatusResponse::ok([
//				"count"=>$count,
				"list" => $categoryList
			]);
		}else{
			return JsonStatusResponse::bad([
				"msg"=>"empty zip file"
			]);
		}
	}
	/**
	 * カテゴリの一覧を取得する。
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function postCategoryList(API $api){
		$list = $api->getAlbum()->image()->getCategories();

		return JsonStatusResponse::ok([
			"list" => $list
		]);
	}
	/**
	 * カテゴリの詳細を取得する。
	 * @return \Symfony\Component\HttpFoundation\Response|static
	 */
	public function postCategoryInfo(API $api){
		$key = $this->input->get("category");
		$data = $api->getAlbum()->image()->getByCategory($key);


		return JsonStatusResponse::ok([
			"category" => $data
		]);
	}
}