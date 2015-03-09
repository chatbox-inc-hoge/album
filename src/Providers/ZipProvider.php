<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 16:34
 */
namespace Chatbox\Album\Providers;

use Chatbox\Album\Services\Image;
use Chatbox\Album\Services\Upload;
use Chatbox\Config\Config;

class ZipProvider{

	public function __invoke(Image $image,Upload $upload)
	{
		$upload = new \Chatbox\Album\Services\Zip($image,$upload);
		return $upload;
	}
}