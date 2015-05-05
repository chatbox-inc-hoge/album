<?php
namespace Chatbox\Album;

use Chatbox\Album\Album\ManagerInterface;
use Chatbox\Album\Upload\File;
use Chatbox\Album\Storage\StorageInterface;
use Chatbox\Album\Upload\FormFileLoader;
use Chatbox\Container\ArrayContainer;

/**
 * アップロード済みのデータエンティティ
 *
 * @package Chatbox\Album
 *
 * @property string $category
 * @property string $origin_name
 * @property string $stored_name
 * @property string $size
 * @property string $mime
 */
class Asset extends ArrayContainer{

    /**
     * @var StorageInterface
     */
    protected $storageHandler;

    function __construct($data,StorageInterface $storageInterface)
    {
        $this->storageHandler = $storageInterface;
    }

    public function file()
    {
        $file = $this->storageHandler->getFile($this->category,$this->stored_name);
        return $file;
    }

    public function dumpHttp(){
        $file = $this->storageHandler->getData($this->category,$this->stored_name);
    }

    public function redirectHttp(){
        $file = $this->storageHandler->getUrl($this->category,$this->stored_name);
    }
}