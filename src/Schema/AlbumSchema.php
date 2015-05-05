<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/04/21
 * Time: 22:02
 */

namespace Chatbox\Album\Schema;

use Chatbox\Migrate\Doctrine\Schema;

class AlbumSchema extends Schema{

    protected $prefix = "album_";

    public function configure()
    {
        $this->_addTable(new Book("{$this->prefix}book"));
        $this->_addTable(new Data("{$this->prefix}data"));
        $this->_addTable(new Tags("{$this->prefix}tags"));
    }


}