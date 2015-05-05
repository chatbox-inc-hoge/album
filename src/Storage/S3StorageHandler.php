<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/05/05
 * Time: 20:02
 */

namespace Chatbox\Album\Storage;


use Chatbox\Album\Upload\File;
use Symfony\Component\Filesystem\Filesystem;

class S3StorageHandler implements StorageInterface {

    protected $path;

    function __construct($path)
    {
        $this->path = $path;
    }

    public function save(File $file){
        $fs = new Filesystem();
        $path = $this->path."/".$file->getCategory()."/".$file->getStoredName();
        $fs->copy($file->getFilename(),$path);


    }

}