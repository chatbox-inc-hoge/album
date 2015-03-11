<?php
/**
 * Created by PhpStorm.
 * User: t.goto
 * Date: 2014/12/02
 * Time: 10:55
 */
namespace Chatbox\Album\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Finder\Finder;

use Chatbox\Album\Services\Image;


class Dump extends Base{

    public function configure(){
        $this->setName("dump");
        $this->setDescription("dump image from database to filesystem");
        parent::configure();
        $this->addArgument("category",InputArgument::REQUIRED,"category name");
    }

    protected function execute(InputInterface $input, OutputInterface $output){
	    $this->loadConfig($input);
	    $output->writeln("hogehoge");

	    $book = $this->album()->book()->getByCategory($input->getArgument("category"));
	    $book->dumpByHash(getcwd()."/tmp");

//        $category = "common";
//        $imageList = $this->album->image()->getByCategory($category);
//
//        $fp = fopen(getcwd()."/export.csv","w");
//        foreach($imageList as $image){
//            if($image instanceof Image){
//                $data = file_get_contents($image->getUploadPath());
//                $fields = $image->getEloquent()->toArray();
//                unset($fields["id"]);
//                unset($fields["category"]);
//                unset($fields["created_at"]);
//                unset($fields["updated_at"]);
//                $fields[] = base64_encode($data);
//                fputcsv($fp,$fields);
//            }
//        }

//        $dir = getcwd()."/".$input->getArgument("dir")."/";
//
//        $finder = new Finder();
//        $finder->files()->in($dir);
//
//        foreach ($finder as $file) {
//            $album = new \Chatbox\Album\Album();
//	        $origin = $file->getRelativePathname();
//	        $cate = $file->getRelativePath();
//	        $data = file_get_contents($dir.$file->getRelativePathname());
//            $album->upload($origin,$data,$cate)->save();
//        }
	}
}