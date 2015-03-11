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

use Chatbox\Album\Album;
use Chatbox\Config\Config;

use Illuminate\Database\Capsule\Manager as Capsule;



abstract class Base extends Command{

    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Album
     */
    private $album=null;
	/**
	 * @var Capsule
	 */
	private $capsule = null;

	public function configure()
	{
        \Chatbox\PHPUtil::bootEloquent("mysql://root@127.0.0.1/misaki");

//        $config = Album::config();
////        $config->load(getcwd()."/appconfig.php");
//        $this->album = new Album($config);
		//共通オプション
//        $this->addOption("config","c",InputOption::VALUE_OPTIONAL,"configuration file","database.php");
//        $this->addOption("host",null,InputOption::VALUE_OPTIONAL,"connection setting",null);
	}

	/**
	 * @param InputOption $input
	 */
	public function loadConfig(InputInterface $input){
		$config = Album::config();
		foreach($input->getOptions() as $key=>$value){

		}
		$this->config = $config;
		\Chatbox\PHPUtil::bootEloquent("mysql://root@127.0.0.1/misaki"); // TODO 設定から読み込み
	}

	public function album(){
		if(is_null($this->album)){
			$this->album = new Album($this->config);
		}
		return $this->album;
	}
}