<?php

require dirname(__DIR__).'/vendor/autoload.php';

use React\EventLoop\Factory;
use React\Socket\Server as SocketServer;
use Pseudo\PhpServiceTemplate\AppServer;

$loop = Factory::create();

$appServer = new AppServer(loop: $loop);

$socketServer = new SocketServer($appServer->getUri(), $loop);

$httpServer = $appServer->build();
$httpServer->listen($socketServer);

echo 'Listening on ' . str_replace('tcp:', 'http:', $socketServer->getAddress()) . "\n";

$loop->run();
