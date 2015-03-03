<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/02
 * Time: 20:16
 */

namespace Chatbox\Album;

use Chatbox\Box\Box;
use Chatbox\Config\Config;

use Chatbox\Album\Providers\UploadProvider;
use Chatbox\Album\Providers\ImageProvider;

use Chatbox\Album\Services\Upload;

class Album extends Box{

    static public function config(){
//        $config = new Config();
        $config = Config::forge();
        $config->load(__DIR__."/../config/album.php");
        return $config;
    }

    private $config;

    public function __construct(Config $config){
        $this->config = $config;
        $this->configure();
    }

    public function configure(){
        parent::configure();
        $this->register("image",["config"],new ImageProvider());
        $this->register("upload",["config"],new UploadProvider());
        $this->register("config",[],function(){
            return $this->config;
        });
    }
    /**
     * @return Upload
     */
    public function upload(){
        return $this->get("upload");
    }
    /**
     * @return Services\Image
     */
    public function image(){
        return $this->get("image");
    }
}