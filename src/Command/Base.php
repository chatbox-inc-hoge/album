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

use Illuminate\Database\Capsule\Manager as Capsule;



abstract class Base extends Command{

    /**
     * @var Album
     */
    protected $album;
	/**
	 * @var Capsule
	 */
	private $capsule = null;

	public function configure()
	{
        \Chatbox\PHPUtil::bootEloquent("mysql://root@127.0.0.1/misaki");

        $config = Album::config();
        $config->load(getcwd()."/appconfig.php");
        $this->album = new Album($config);
//        $this->addOption("config","c",InputOption::VALUE_OPTIONAL,"configuration file","database.php");
//        $this->addOption("host",null,InputOption::VALUE_OPTIONAL,"connection setting",null);
	}
}