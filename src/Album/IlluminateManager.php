<?php
namespace Chatbox\Album\Album;

use Chatbox\Album\Upload\File;

/**
 * データベースへのCRUDを担当するマッパー。
 * 状態を持たない。シングルトン推奨。
 * @package Chatbox\Album
 */
class IlluminateManager implements ManagerInterface{

    protected $bookTableName;
    protected $tagTableName;
    protected $conn;

    function __construct($bookTableName, $tagTableName, $conn)
    {
        $this->bookTableName = $bookTableName;
        $this->tagTableName = $tagTableName;
        $this->conn = $conn;
    }


    public function save(File $file){
        $this->table()->insert([
            "category" => $file->getCategory(),
            "origin_name" => $file->getOriginName(),
            "stored_name" => $file->getStoredName(),
            "size" => $file->getSize(),
            "mime" => $file->getMimeType(),
        ]);
    }


    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function bookTable(){
        $con = app("db")->connection($this->conn);
        $query = $con->table($this->bookTableName);
        return $query;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function tagTable(){
        $con = app("db")->connection($this->conn);
        $query = $con->table($this->tagTableName);
        return $query;
    }


}