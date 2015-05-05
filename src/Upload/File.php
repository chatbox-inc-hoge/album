<?php
namespace Chatbox\Album\Upload;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/05/05
 * Time: 20:03
 */

use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class File extends SymfonyFile{

    protected $originName;

    protected $storedName;

    protected $resource;

    protected $category = "default";

    /**
     * @return mixed
     */
    public function getOriginName()
    {
        return $this->originName;
    }

    /**
     * @return mixed
     */
    public function getStoredName()
    {
        return $this->storedName;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function setOriginName($originName){
        $this->originName = $originName;
    }

    /**
     * @param mixed $storedName
     */
    public function setStoredName($storedName)
    {
        $this->storedName = $storedName;
    }

    /**
     * 一時ファイル作成時に、
     * ファイルポインタを格納してファイルの消滅を防ぐ
     * @param $resource
     */
    public function setResource($resource){
        $this->resource = $resource;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }






}