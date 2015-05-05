<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/05/05
 * Time: 20:02
 */

namespace Chatbox\Album\Storage;


use Chatbox\Album\Upload\File;

interface StorageInterface {

    public function save(File $file);

    /**
     * ファイル情報からファイルオブジェクトを生成して返す。
     * @param $category
     * @param $storedName
     * @return File
     */
    public function getFile($category,$storedName);
    /**
     * ファイル情報からファイルデータを返す。
     * @param $category
     * @param $storedName
     * @return File
     */
    public function getData($category,$storedName);
    /**
     * データ情報からHTTPのマッピングURLを返す。
     * @param $category
     * @param $storedName
     * @return File
     */
    public function getUrl($category,$storedName);
}