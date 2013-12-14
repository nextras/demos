<?php

use Nette\Application\Routers\Route;


require __DIR__ . '/../libs/autoload.php';


umask(0);
$configurator = new Nette\Config\Configurator;
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$loader = $configurator->createRobotLoader();
$dirs = array(
	APP_DIR . '/../../application/Nextras',
	APP_DIR . '/../../datagrid/Nextras',
	APP_DIR . '/../../forms/Nextras',
	APP_DIR . '/../../latte-macros/Nextras',
);
foreach ($dirs as $dir) {
	if (file_exists($dir)) {
		$loader->addDirectory($dir);
	}
}
$loader->addDirectory(APP_DIR);
$loader->register();

$configurator->addConfig(__DIR__ . '/config.neon');
$container = $configurator->createContainer();

$container->router[] = new Route('', 'Homepage:default');
$container->router[] = new Route('<presenter>/<action>');

$container->application->run();



function getNextrasDemosSource($path)
{
	if (file_exists(APP_DIR . '/../libs/nextras/' . $path)) {
		return APP_DIR . '/../libs/nextras/' . $path;
	} else {
		return APP_DIR . '/../../' . $path;
	}
}

function getNextrasDemosSourceWeb($path)
{
	if (file_exists(APP_DIR . '/../libs/nextras/' . $path)) {
		return '/../libs/nextras/' . $path;
	} else {
		return '/../../' . $path;
	}
}
