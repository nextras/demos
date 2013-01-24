<?php

use Nette\Application\Routers\Route;


require __DIR__ . '/../libs/autoload.php';



$configurator = new Nette\Config\Configurator;
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
	->addDirectory(APP_DIR . '/../../datagrid/Nextras')
	->addDirectory(APP_DIR . '/../../forms/Nextras')
	->addDirectory(APP_DIR)
	->register();

$configurator->addConfig(__DIR__ . '/config.neon');
$container = $configurator->createContainer();

$container->router[] = new Route('', 'Homepage:default');
$container->router[] = new Route('<presenter>/<action>');

$container->application->run();



function getNextrasDemosSource($path)
{
	if (file_exists(APP_DIR . '../libs/nextras/' . $path)) {
		return APP_DIR . '/../libs/nextras/' . $path;
	} else {
		return APP_DIR . '/../../' . $path;
	}
}

function getNextrasDemosSourceWeb($path)
{
	if (file_exists(APP_DIR . '../libs/nextras/' . $path)) {
		return '/../libs/nextras/' . $path;
	} else {
		return '/../../' . $path;
	}
}
