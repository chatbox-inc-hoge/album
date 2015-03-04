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
use Chatbox\Album\Services\Eloquent\Image as Eloquent;
use Chatbox\Album\Services\Eloquent\Data as EloquentData;


class ImportDB extends Base{

    public function configure(){
        $this->setName("import:db");
        $this->setDescription("exports data to file");
        parent::configure();
        $this->addArgument("category",InputArgument::REQUIRED,"category name");
        $this->addArgument("path",InputArgument::REQUIRED,"file path");
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $category = $input->getArgument("category");
        $path = getcwd()."/".$input->getArgument("path");
        $fp = fopen($path,"r");
        $row = null;
        while(($row = fgetcsv($fp))!=false){
            list($originName,$hashedName,$size,$mime,$comment,$meta,$binary) = $row;
            try{
                $upload = $this->album->upload()
                    ->dumpTmpFile($originName,base64_decode($binary));
                $image = $this->album->image()
                    ->store($category,$hashedName,$comment,$meta,$upload);
            }catch (\Exception $e){
                $output->writeln("fail to import");
                $output->writeln(substr($e->getMessage(),0,120));
                exit(1);
            }
            unset($upload);
            unset($image);
            unset($row);
        }
        $output->writeln("hogehoge");
	}
}