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


class Sync extends Base{

    public function configure(){
        $this->setName("upload");
        $this->setDescription("create database");
        parent::configure();
        $this->addArgument("dir",InputArgument::REQUIRED,"directory name");
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $dir = getcwd()."/".$input->getArgument("dir")."/";

        $finder = new Finder();
        $finder->files()->in($dir);

        foreach ($finder as $file) {
            $album = new \Chatbox\Album\Album();
	        $origin = $file->getRelativePathname();
	        $cate = $file->getRelativePath();
	        $data = file_get_contents($dir.$file->getRelativePathname());
            $album->upload($origin,$data,$cate)->save();
        }
	}
}