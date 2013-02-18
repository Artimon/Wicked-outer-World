<?php

return array(
	'profile' => array(
		'controller'	=> 'ControllerProfile',
		'database'		=> true
	),
	'academy' => array(
		'controller'	=> 'ControllerAcademy',
		'database'		=> true
	),
	'hangar' => array(
		'controller'	=> 'ControllerHangar',
		'database'		=> true
	),
	'factory' => array(
		'controller'	=> 'ControllerFactory',
		'database'		=> true
	),
	'techInfo' => array(
		'controller'	=> 'ControllerTechInfo',
		'ajax'			=> true
	),
	'entities' => array(
		'controller'	=> 'ControllerEntities',
		'database'		=> true,
		'ajax'			=> true
	),
	'fight' => array(
		'controller'	=> 'ControllerFight',
		'database'		=> true
	),
	'logout' => array(
		'controller'	=> 'ControllerLogout',
		'database'		=> true
	),
	'default' => array(
		'controller'	=> 'ControllerLogin',
		'database'		=> true
	)
);