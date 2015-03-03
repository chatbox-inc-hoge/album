<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/01/22
 * Time: 0:00
 */

namespace Chatbox\Album\Eloquent;


use Chatbox\Album\Album;

class Image extends \Chatbox\TmpData\Eloquent\TmpData{

    protected $table = "album_image";

    protected $fillable = ["category","origin_name","hashed_name","size","mime","comment","meta"];

	public function toArray(){
		$data = parent::toArray();
		$album = new Album();
		$data["url"] = $album->getHttpPath($this);
		return $data;
	}
} 