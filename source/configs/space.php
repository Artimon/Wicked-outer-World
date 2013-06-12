<?php

define('HOMEWORLD_ID', 0);
define('ASTERIOD_FIELD_ID', 1);
define('OLD_BATTLEFIELD_ID', 2);

/*
 * Maybe add "connected to" settings, like in x-beyond?
 */

$starmap = array();
$starmap[HOMEWORLD_ID] = array(
	'name'	=> 'earth',
	'x'		=> 200,
	'y'		=> 450,
	'spaceStation'	=> array()
);
$starmap[ASTERIOD_FIELD_ID] = array(
	'name'	=> 'asteroidField',
	'x'		=> 250,
	'y'		=> 400,
	'enemies'	=> array(),
	'items'		=> array(
		SPACE_JUNK_ID => 35		// Propability to find item
	)
);
$starmap[OLD_BATTLEFIELD_ID] = array(
	'name'	=> 'oldBattlefield',
	'x'		=> 180,
	'y'		=> 420,
	'enemies'	=> array(),
	'items'		=> array(
		ENERGY_CELLS_ID	=> 15,	// Propability to find item
		SPACE_JUNK_ID	=> 95	// Propability to find item
	)
);