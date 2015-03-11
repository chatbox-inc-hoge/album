<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/28
 * Time: 16:27
 */

namespace Chatbox\Album\Services;


use Chatbox\Album\Services\Upload;
use Symfony\Component\Config\Definition\Exception\Exception;

use ZipArchive;

class Zip {

	/**
	 * @var Upload
	 */
	protected $upload;

	/**
	 * @var Image
	 */
	protected $image;

	/**
	 * @var ZipArchive
	 */
	protected $zip;

    function __construct(Image $image,Upload $upload,ZipArchive $zip=null)
    {
	    $this->image = $image;
	    $this->upload = $upload;

	    $this->zip=$zip;
    }

	protected function newInstance(ZipArchive $zip){
		return new static($this->image,$this->upload,$zip);
	}

	public function open($data){
		$fp = tmpfile();
		$path = stream_get_meta_data($fp)["uri"];
		file_put_contents($path,$data);
		$this->zip = new \ZipArchive();
		$this->fp = $fp;//この変数の寿命が一時ファイルの寿命

		return ($this->zip->open($path) === true);
	}

	/**
	 * @return ZipArchive
	 * @throws \Exception
	 */
	protected function zip(){
		if($this->zip){
			return $this->zip;
		}else{
			throw new \Exception("cant get empty zip");
		}
	}

	public function count(){
		return $this->zip()->numFiles;
	}

	/**
	 * @param $category
	 * @param $data
	 * @return \ZipArchive
	 * @throws \Exception
	 */
	public function extract($category){
		$zip = $this->zip();
	    for($i=0;$i<$this->count();$i++){
//		    $zip->open($this->path);
		    $fileData = $zip->statIndex($i);
		    $entryName = $fileData["name"];
		    if( $entryName === "composit.json" ){

		    }else{
			    if($zipfp = $zip->getStream($entryName)){
				    $data = stream_get_contents($zipfp);
				    $upload = $this->upload->dumpTmpFile($fileData["name"],$data);
				    $newImage = $this->image->create($category,"",$upload);
//				    fclose($zipfp);
			    }else{
				    throw new \Exception("fail to get entry from archive $entryName(count $i)");
			    }
		    }
	    }
    }
//	/**
//	 * @param $category
//	 * @param $data
//	 * @return \ZipArchive
//	 * @throws \Exception
//	 */
//	public function extract($category,$data){
//	    $fp = tmpfile();
//	    $path = stream_get_meta_data($fp)["uri"];
//	    file_put_contents($path,$data);
//
//	    $zip = new \ZipArchive();
//	    if($zip->open($path)){
//		    for($i=0;$i<$zip->numFiles;$i++){
//			    $zip->open($path);
//			    $fileData = $zip->statIndex($i);
//			    $entryName = $fileData["name"];
//			    if( $entryName === "composit.json" ){
//
//			    }else{
//				    if($zipfp = $zip->getStream($entryName)){
//					    $data = stream_get_contents($zipfp);
//					    $upload = $this->upload->dumpTmpFile($fileData["name"],$data);
//					    $newImage = $this->image->create($category,"",$upload);
//					    fclose($zipfp);
//				    }else{
//					    throw new \Exception("hoge {$entryName}");
//				    }
//			    }
//		    }
//		}else{
//			throw new \Exception("hoge");
//	    }
//	    return $zip;
//
//    }
}