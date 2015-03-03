<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2014/12/03
 * Time: 0:12
 */

namespace Chatbox\Album;

/**
 * 参考
 * http://qiita.com/mpyw/items/939964377766a54d4682
 * Class Upload
 * @package Album
 *
 */
class Upload {

    static public function forge($key){
        return new static($key);
    }

    protected $key;
    protected $maxFileSize;

    function __construct($key,$maxFileSize=null)
    {
        $this->key = $key;
        $this->maxFileSize = $maxFileSize;
    }

    public function getOriginName(){
        return $_FILES[$this->key]['name'];
    }
    public function getSize(){
        return $_FILES[$this->key]['size'];
    }
    public function getError(){
        if(!isset($_FILES[$this->key]['error']) || !is_int($_FILES[$this->key]['error'])){
            throw new RuntimeException('パラメータが不正です');
        }
        return (int)$_FILES[$this->key]['error'];
    }
    public function tmpFilePath(){
        return $_FILES[$this->key]['tmp_name'];
    }
    public function getFileType(){
        // $_FILES['upfile']['mime']の値はブラウザ側で偽装可能なので
        // MIMEタイプに対応する拡張子を自前で取得する
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->file($this->tmpFilePath());
    }

    protected function validate(){
        switch ($this->getError()) {
            case UPLOAD_ERR_OK: // OK
                break;
            case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                throw new RuntimeException('ファイルが選択されていません');
            case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
            case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
                throw new RuntimeException('ファイルサイズが大きすぎます');
            default:
                throw new RuntimeException('その他のエラーが発生しました');
        }

        if ($this->maxFileSize && $this->getSize() > $this->maxFileSize) {
            throw new RuntimeException('ファイルサイズが大きすぎます');
        }
    }


} 