<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/03
 * Time: 0:12
 */

namespace Chatbox\Album\HTTP;

use Chatbox\Album\Album;
use Chatbox\Silane;
use Chatbox\Config\Config;

use Chatbox\Silane\Providers\RestErrorHandlerProvider;

class API extends Silane{


    static public function config(){
        $config = Album::config();
        $config->load(__DIR__."/../../config/silane.php");
        return $config;
    }

//    public function __construct(array $values = array())
//    {
//        parent::__construct($values);
//
//        $this->register(new RestErrorHandlerProvider());
//        $this->mount("/upload", new Controllers\Upload());
//        $this->mount("/photo", new Controllers\Photo());
//        $this->mount("/image", new Controllers\Image());
//        $this->mount("/i", new Controllers\Redirect());
//    }




    public function configure(){
        $this["album"] = new Album($this->getConfig());
    }

    /**
     * @return Album
     */
    public function getAlbum(){
        return $this["album"];
    }


}