<?php
namespace Chatbox\Album\Album;

use Chatbox\Album\Upload\File;

/**
 * データベースへのCRUDを担当するマッパー。
 * 状態を持たない。シングルトン推奨。
 * @package Chatbox\Album
 */
interface ManagerInterface {

    public function save(File $file);

    public function findBy($cond);

    public function find($category,$name);

}