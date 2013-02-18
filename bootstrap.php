<?php

/*
 * Contains all code needed to start up the project.
 */

$baseDir = __DIR__;

require_once $baseDir . '/ext/valkyrie/valkyrie/Autoloader.php';

$autoloader = Valkyrie_Autoloader::create();
$autoloader
	->setScriptGroup('temp')
	->setBuildPath($baseDir . '/source/build')
	->addSourcePath($baseDir . '/source/lib')
	->addSourcePath($baseDir . '/ext/lisbeth')
	->addSourcePath($baseDir . '/ext/leviathan')
	->lowerCasePaths()
	->start(false);