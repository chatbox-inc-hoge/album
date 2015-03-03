<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/02
 * Time: 20:16
 */

namespace Chatbox\Album;

use Chatbox\HTTP;
use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

use Symfony\Component\Filesystem\Filesystem;

class Album {

	protected $defaultCategory="default";

    protected $baseDir;
	protected $httpPath;

    public function __construct(array $param=[]){
        $this->baseDir = __DIR__."/../sample/images/";
        $this->httpPath = "/images/";
        $config = [
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => 'misaki',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ];
        $this->setUpEloquent($config);
    }

    protected function setUpEloquent($config){
        $capsule = new Capsule;

        $capsule->addConnection($config);
        $capsule->setAsGlobal();

        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->bootEloquent();
    }

	/**
	 * saveしない方向で。
	 * @param $originName
	 * @param $sourceData
	 * @param string $category
	 * @param string $comment
	 * @param array $meta
	 * @return Eloquent\Image
	 * @throws \Exception
	 */
	public function upload($originName,&$sourceData,$category="",$comment="",array $meta=[]){
        if($sourceData){
            // ソースファイルの解析 & 移動
	        $fs = new \Chatbox\Filesystem();
	        $ext = $fs->getExt($originName);
	        $hashed_name = sha1($originName.time());
	        $hashed_name .= ($ext)?".$ext":"";
	        $path = $this->baseDir.$hashed_name;
	        $fs->dumpFile($path,$sourceData);

//            $mime = \Chatbox\Filesystem::with()->getMime($path);
	        $mime = "image/png";

            $image = $this->getEloquent([
                "category"=>$category?:$this->defaultCategory,
                "origin_name"=>$originName,
                "hashed_name"=>$hashed_name,
                "size"=>strlen($sourceData),
                "mime"=>$mime,
                "comment"=>$comment,
                "meta"=>json_encode($meta),
            ]);
            return $image;
        }else{
            throw new \Exception("source is empty");
        }
    }

	/**
	 * @param array $data
	 * @return \Chatbox\Album\Eloquent\Image
	 */
	public function getEloquent(array $data=[]){
		$image = new \Chatbox\Album\Eloquent\Image($data);
		return $image;
	}

	public function book($category){
		$image = $this->getEloquent();
		$book = $image->where("category",$category)->get();

		return $book;
	}

	public function getOne($category,$originName){
		$image = $this->getEloquent();
		$image = $image->where("category",$category)->where("origin_name",$originName)->firstOrFail();
		return $image;
	}

	public function getHttpPath(\Chatbox\Album\Eloquent\Image $image){
		if($image && $image->hashed_name){
			$url = $this->httpPath.$image->hashed_name;
			return $url;
		}else{
			throw new \Exception("hogehoge");
		}

	}

	public function redirect(\Chatbox\Album\Eloquent\Image $image){
		HTTP::redirect($this->getHttpPath($image));
	}
} 