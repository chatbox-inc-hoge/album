<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 16:27
 */

namespace Chatbox\Album\Services;

use Chatbox\Filesystem;

class Upload {

    protected $tmpPath;
    protected $mime;
    protected $size;

    protected $originName;
    protected $fileCache;

    function __construct($tmpPath=null)
    {
        if($tmpPath && file_exists($tmpPath)){
            $this->tmpPath = $tmpPath;
            $this->size = strlen($this->loadData());
            $this->mime = "image/jpeg";
        }elseif($tmpPath){
            throw new \Exception("not existing file ");
        }
    }

    public function getMime(){
        return $this->mime;
    }

    public function getSize(){
        return $this->size;
    }

    public function loadData(){
        if(!$this->fileCache){
            if($this->tmpPath){
                $this->fileCache = file_get_contents($this->tmpPath);
            }else{
                throw new \Exception("cant load empty path");
            }
        }
        return $this->fileCache;

    }

    ## region ファクトリー

    protected function newInstance($path){
        return new static($path);
    }

    public function load($key){

    }

    public function dumpTmpFile($originName,$sourceData){
        $fp = tmpfile();
        fwrite($fp,$sourceData);
        $path = stream_get_meta_data($fp)["uri"];
        $ins = $this->newInstance($path);
        $ins->setOriginName($originName);
        return $ins;
    }

    ## endregion

    public function setOriginName($name){
        $this->originName = $name;
    }

    public function getOriginName($default=null){
        if($this->originName){
            return $this->originName;
        }else{
            if(func_num_args()){
                return $default;
            }else{
                throw new \Exception("originName and default value not set");
            }
        }
    }

    public function move($newPath){
        if($this->tmpPath){
            $fs = new Filesystem();
            $fs->dumpFile($newPath,$this->loadData());
        }else{
            throw new \Exception("cant move non exist file");
        }
    }
} 