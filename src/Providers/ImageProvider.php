<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 16:34
 */
namespace Chatbox\Album\Providers;

use Chatbox\Album\Services\Image;
use Chatbox\Config\Config;

class ImageProvider{

    public function __invoke(Config $config)
    {
        $image = new Image($config);
        return $image;
    }
}