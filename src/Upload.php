<?php
namespace Chatbox\Album;

use Chatbox\Album\Album\ManagerInterface;
use Chatbox\Album\Upload\File;
use Chatbox\Album\Storage\StorageInterface;
use Chatbox\Album\Upload\FormFileLoader;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/05/05
 * Time: 19:56
 */

class Upload {

    /** @var ManagerInterface */
    protected $albumManager;

    /** @var StorageInterface */
    protected $storageHandler;

    /** @var File */
    protected $file;

    function __construct(ManagerInterface $albumManager,StorageInterface $storageHandlers)
    {
        $this->albumManager = $albumManager;
        $this->storageHandlers = $storageHandlers;
    }

    public function form($key){
        $loader = new FormFileLoader();
        $this->file = $loader->load($key);
        return $this;
    }

    public function input($key){
        $loader = new FormFileLoader();
        $this->file = $loader->load($key);
        return $this;
    }

    /** @return File */
    public function file(){
        return $this->file;
    }

    public function save($storedName = null){
        is_null($storedName) && ($storedName = sha1(time().mt_rand()));
        $this->file->setStoredName($storedName);
        $this->albumManager->save($this->file);
        $this->storageHandler->save($this->file);
    }

}