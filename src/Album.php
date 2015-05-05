<?php
namespace Chatbox\Album;

use Chatbox\Album\Album\ManagerInterface;
use Chatbox\Album\Upload\File;
use Chatbox\Album\Storage\StorageInterface;
use Chatbox\Album\Upload\FormFileLoader;

/**
 * UploadとAssetのサービスを生成する
 * インターフェイス的役割
 * 依存関係はココに全てまとめきる。
 */
class Album {

    /** @var ManagerInterface */
    protected $albumManager;

    /** @var StorageInterface[] */
    protected $storageHandlers = [];

    function __construct(ManagerInterface $albumManager,array $storageHandlers,File $file=null)
    {
        $this->albumManager = $albumManager;
        $this->storageHandlers = $storageHandlers;
    }

    public function upload($storageHandlerName){
        $storageHandler = $this->storageHandlers[$storageHandlerName];
        return new Upload($this->albumManager,$storageHandler);
    }

    public function getList($cond){
        $arr = $this->albumManager->findBy($cond);




    }

    public function find($category,$name){
        $assetData = $this->albumManager->find($category,$name);

        $storageHandler = $this->

        $asset = new Asset($assetData,$storage);

    }

}