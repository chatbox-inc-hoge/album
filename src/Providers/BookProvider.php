<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 16:34
 */
namespace Chatbox\Album\Providers;

use Chatbox\Album\Services\Image;
use Chatbox\Album\Services\Book;
use Chatbox\Config\Config;

class BookProvider{

    public function __invoke(Config $config,Image $image)
    {
        $book = new Book($config,$image);
        return $book;
    }
}