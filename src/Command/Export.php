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


class Export extends Base{

    public function configure(){
        $this->setName("export");
        $this->setDescription("exports data to file");
        parent::configure();
//        $this->addArgument("dir",InputArgument::REQUIRED,"directory name");
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $category = "common";
        $imageList = $this->album->image()->getByCategory($category);

        $fp = fopen(getcwd()."/export.csv","w");
        foreach($imageList as $image){
            if($image instanceof Image){
                $data = file_get_contents($image->getUploadPath());
                $fields = $image->getEloquent()->toArray();
                unset($fields["id"]);
                unset($fields["category"]);
                unset($fields["created_at"]);
                unset($fields["updated_at"]);
                $fields[] = base64_encode($data);
                fputcsv($fp,$fields);
            }
        }
        $output->writeln("hogehoge");

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