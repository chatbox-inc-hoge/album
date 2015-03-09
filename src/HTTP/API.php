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