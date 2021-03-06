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

class Tags extends Table{

    use OptionalColumnTrait;

    protected function configure()
    {
        $this->addSurrogateKey();
        $this->addId("image_id");
        $this->addString("tag_name");
        $this->addString("tag_value");
        $this->addTimestamps();
    }


}