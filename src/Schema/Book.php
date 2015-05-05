<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/05/04
 * Time: 4:01
 */

namespace Chatbox\Album\Schema;


use Chatbox\Migrate\Doctrine\OptionalColumnTrait;
use Chatbox\Migrate\Doctrine\Table;

class Book extends Table{

    use OptionalColumnTrait;

    protected function configure()
    {
        $this->addSurrogateKey();
        $this->addString("category");
        $this->addString("origin_name");
        $this->addString("stored_name");
        $this->addInteger("size");
        $this->addString("mime");
        $this->addString("storage");
        $this->addTimestamps();
    }


}