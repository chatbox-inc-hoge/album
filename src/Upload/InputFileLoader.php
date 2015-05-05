<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/05/05
 * Time: 20:14
 */

namespace Chatbox\Album\Upload;


class InputFileLoader {

    /**
     * 送信側でどういうエンコードをされてるかとか考えると
     * 色々とめんどくさいので、データとして引数で受け取る。
     * @param $data
     */
    public function load($data,$originName = null){
        $fp = tmpfile();
        $path = stream_get_meta_data($fp)["uri"];
        fwrite($fp,$data);

        $file = new File($path);
        $file->setOriginName($originName);
        $file->setResource($fp);
        return $file;
    }



}