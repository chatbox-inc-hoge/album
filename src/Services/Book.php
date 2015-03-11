<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 12:59
 */

namespace Chatbox\Album\Services;

use Chatbox\Config\Config;
use Chatbox\Filesystem;
use Chatbox\PHPUtil;
use Chatbox\Album\Services\Image;
use Chatbox\Album\Services\Eloquent\Image as Eloquent;

/**
 * 複数の画像を取りまとめて扱うほげほげ
 * @package Chatbox\Album\Services
 */
class Book implements \JsonSerializable{

	/**
	 * @var Config
	 */
	private $config;
	/**
	 * @var Image
	 */
	private $image;
    /**
     * @var Image[]
     */
    private $images;

    function __construct(Config $config,Image $image,array $images = [])
    {
        $this->config = $config;
	    $this->image = $image;
        $this->images = $images;
    }

	/**
	 * @param array $images
	 * @return Book
	 */
	protected function newInstance(array $images){
        return new static($this->config,$this->image,$images);
    }

	/**
	 * @param $category
	 * @param null $pageSize
	 * @param null $pageNum
	 * @return Book
	 */
	public function getByCategory($category,$pageSize=null,$pageNum=null){
        $list = Eloquent::where("category",$category)->get();
        $rtn = [];
        foreach($list as $image){
            $rtn[] = $this->image->newInstance($image);
        }
        return $this->newInstance($rtn);
    }

	public function getCategories(){
		$list = Eloquent::groupBy("category")->get();
		$rtn = [];
		foreach($list as $image){
			$rtn[$image["category"]] = $this->newInstance($image);
		}
		return $rtn;
	}

	public function dumpByHash($dest){
		$fs = new Filesystem();
		foreach($this->images as $image){
			$filename = $dest."/".$image->getEloquent()->hashed_name;
			$content = $image->getEloquent()->data->data;
			echo $filename . PHP_EOL;
			$fs->dumpFile($filename,$content);
		}
	}

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        $data = $this->eloquent->toArray();
        $data["url"] = $this->getUrl();
        $data["hashedUrl"] = $this->getUrl();
        $data["originUrl"] = "/i/gd/{$data["category"]}/{$data["origin_name"]}";
        $data["redirectUrl"] = "/i/src/{$data["category"]}/{$data["origin_name"]}";
        return $data;
    }


} 