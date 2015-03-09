<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 12:59
 */

namespace Chatbox\Album\Services;

use Chatbox\Album\Services\Eloquent\Image as Eloquent;
use Chatbox\Album\Services\Eloquent\Data as EloquentData;
use Chatbox\Config\Config;
use Chatbox\PHPUtil;

class Image implements \JsonSerializable{

    private $config;
    /**
     * @var Eloquent
     */
    private $eloquent;

    function __construct(Config $config,Eloquent $eloquent=null)
    {
        $this->config = $config;
        $this->eloquent = $eloquent;
    }

    public function getUploadPath(){
        $path  = $this->config->get("image.uploadDir");
        $path .= $this->getEloquent()->category;
        $path .= "/";
        $path .= $this->getEloquent()->hashed_name;
        return $path;
    }
    public function getUrl(){
        $url  = $this->config->get("image.httpPath");
        $url .= $this->eloquent->category;
        $url .= "/";
        $url .= $this->eloquent->hashed_name;
        return $url;
    }

    /**
     * @param $eloquent
     * @return Image
     */
    protected function newInstance($eloquent){
        return new static($this->config,$eloquent);
    }

    /**
     * @param $category
     * @param $comment
     * @param Upload $upload
     * @return Image
     */
    public function create($category,$comment,Upload $upload){
        $hashedName = sha1(mt_rand(0,999999).time());
        return $this->store($category,$hashedName,$comment,"",$upload);
    }

    public function store($category,$hashedName,$comment,$meta,Upload $upload){
        $image = Eloquent::create([
            "category"=>$category,
            "origin_name"=>$upload->getOriginName(),
            "hashed_name"=>$hashedName,
            "size"=>$upload->getSize(),
            "mime"=>$upload->getMime(),
            "comment"=>$comment,
            "meta"=>$meta,
        ]);
        $dataEloq = new EloquentData([
            "data" => $upload->loadData()
        ]);
        $image->data()->save($dataEloq);

        $image = $this->newInstance($image);
        $upload->move($image->getUploadPath());
        return $image;

    }

    /**
     * @return Eloquent
     */
    public function getEloquent(){
        if($this->eloquent){
            return $this->eloquent;
        }else{
            throw new Exception("no eloquent set");
        }
    }

    public function dumpFile(){

    }

    /**
     * @param $category
     * @param $id
     * @return Image|null
     */
    public function fetch($where){
        $image = Eloquent::where($where)->first();
        if($image){
            return $this->newInstance($image);
        }else{
            return null;
        }
    }

    public function getByCategory($category,$pageSize=null,$pageNum=null){
        $list = Eloquent::where("category",$category)->get();
        $rtn = [];
        foreach($list as $image){
            $rtn[] = $this->newInstance($image);
        }
        return $rtn;
    }

    public function delete(){
        $path = $this->getUploadPath();
        if(file_exists($path) && is_writable($path)){
            unlink($this->getUploadPath());
        }
        $this->eloquent->data()->delete();
        $this->eloquent->delete();
    }

	public function getCategories(){
		$list = Eloquent::groupBy("category")->get();
		$rtn = [];
		foreach($list as $image){
			$rtn[$image["category"]] = $this->newInstance($image);
		}
		return $rtn;
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