<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/01/22
 * Time: 0:00
 */

namespace Chatbox\Album\Services\Eloquent;


use Chatbox\Album\Album;
use Illuminate\Database\Eloquent\Model;

class Image extends Model{

    protected $table = "album_image";

    protected $fillable = ["category","origin_name","hashed_name","size","mime","comment","meta"];

    public function data()
    {
        return $this->hasOne('Chatbox\Album\Services\Eloquent\Data',"id","id");
    }

	public function getCategories(){

		$res = $this->getConnection()->table($this->table)->groupBy("category")->get();
		$pool = [];
		foreach($res as $val){
			$pool[] = $val["category"];
		}
		return $pool;

	}

//	public function toArray(){
//		$data = parent::toArray();
//		$album = new Album();
//		$data["url"] = $album->getHttpPath($this);
//		return $data;
//	}
} 