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


class Test2 extends Base{

    public function configure(){
        $this->setName("test2");
        $this->setDescription("exports data to file");
        parent::configure();
        $this->addArgument("category",InputArgument::REQUIRED,"category name");
    }

    protected function execute(InputInterface $input, OutputInterface $output){
        $finder = new Finder();
        $files = $finder->depth(0)->files()->in(getcwd()."/image/samplePattern/");
        $fp = fopen(getcwd()."/export_pattern.csv","w");
        foreach($files as $file){
            $fpTmp = fopen($file->getRealpath(),"r");
            $data = fread($fpTmp,filesize($file->getRealpath()));
            fclose($fpTmp);
            $fields = [];
            $fields[] = $file->getRelativePathname();
            $fields[] = sha1($data);
            $fields[] = strlen($data);
            $fields[] = "image/jpeg";
            $fields[] = "some hoge comment";
            $fields[] = "{}";
            $fields[] = base64_encode($data);
            unset($data);
            fputcsv($fp,$fields);
        }
        $output->writeln("hogehoge");
	}
}