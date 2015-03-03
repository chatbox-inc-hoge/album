<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 16:34
 */
namespace Chatbox\Album\Providers;

use Chatbox\Config\Config;

class UploadProvider{

    public function __invoke(Config $config)
    {
        $upload = new \Chatbox\Album\Services\Upload();
        return $upload;
    }
}