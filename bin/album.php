<?php

use \Symfony\Component\Console\Application;

if(!class_exists("\\Chatbox\\Album\\Album")){
    echo "you need to install local migrate.".PHP_EOL;
    exit(1);
}

ini_set("memory_limit",-1);

$console = new Application();
$console->add(new Chatbox\Album\Command\Sync());
$console->add(new Chatbox\Album\Command\Dump());
$console->add(new Chatbox\Album\Command\Export());
$console->add(new Chatbox\Album\Command\ImportDB());
$console->add(new Chatbox\Album\Command\Test());
$console->add(new Chatbox\Album\Command\Test2());

$console->run();

