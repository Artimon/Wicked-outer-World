<?php

// engine still missing, maybe reduce reactor weight a bit
// Ship parts:
// - bridge/cockpit (pilot, systems) hard to hit
// - body (reactor, systems, weapons, ammunition) easy to hit
// - weapon phalanx (weapons, ammunition) medium to hit
// - engine (engine) medium to hit

// Weapons:
// Add bullet amount per firing
// Add accuracy
// Add damage
// Add ammunition type

// Startup:
// Ragnarok Mk I; reactor (-5), plating (-5), laser (-6)... (7 left)
// Ragnarok Mk I; reactor (-5), plating (-4), laser (-6), 2 blaster (-8)... (0 left)
// Ragnarok Mk I; reactor (-5), plating (-6), 2 laser (-12)... (0 left)
// Ragnarok Mk I; reactor (-5), 3 laser (-18)... (0 left)

// Ragnarok Mk I; reactor (-5), plating (-3), cargo (-8)... (7 left)
// Ragnarok Mk I; reactor (-5), plating (-2), 2 cargo (-16)... (0 left)

// Ragnarok Mk I; reactor (-5), plating (-3), junk (-8)... (7 left)
// Ragnarok Mk I; reactor (-5), plating (-2), junk (-8), cargo (-16)... (0 left)

// Buy a ship automatically sells the old ship and unequips everything.
// Level up clan base by putting money in.
// Creating a clan only possible at a certain minimum level.
// Levels give skill points.

define('BLASTER_AMMUNITION_ID', 70);
define('KINETIC_SHIELD_ID', 120);
define('ENERGY_SHIELD_ID', 121);
define('DISTORTION_SHIELD_ID', 122);

define('IRON_ID',					1000);
define('CRYSTALS_ID',				1050);
define('ELECTRONICS_ID',			1100);
define('ENERGY_CELLS_ID',			1150);
define('SPACE_JUNK_ID',				1200);
define('TECHNICAL_COMPONENTS_ID',	1250);


// Galaxy on Fire items:
// http://forums.fishlabs.net/fishlabs-boards-english-20/galaxy-fire-2-124/galaxy-fire-2-java-127/1237-list-items.html


/*
        <====O
    ________M_M____________
  / /_o/ / <==O   | o |  W |C~~~
/______/___<==O___|___|____|C~~~
Cockpit  Weaponry  Body  Engine

*/

$technology = array();
/*$Technology[-1] = array(
	'type'		=> Technology::TYPE_STOCKAGE,
	'name'		=> 'Stockage',
	'weight'	=> 0,
	'tonnage'	=> 30,
	'slots' => array(
		'stock' => 1
	)
);*/
$technology[1] = array(
	'type'		=> Technology::TYPE_STARSHIP,
	'name'		=> 'RagnarokMkI',
	'weight'	=> 30,
	'tonnage'	=> 18,
	'structure'	=> 57,
	'slots' => array(
		'weaponry'		=> 3,
		'ammunition'	=> 2,
		'equipment'		=> 1,
		'cargo'			=> 1,
		'engine'		=> 2
	)
);
$technology[2] = array(
	'type'		=> Technology::TYPE_STARSHIP,
	'name'		=> 'GenesisSC4',
	'weight'	=> 30,
	'tonnage'	=> 21,
	'structure'	=> 33,
	'slots' => array(
		'weaponry'		=> 1,
		'ammunition'	=> 1,
		'equipment'		=> 2,
		'cargo'			=> 3,
		'engine'		=> 2
	)
);

$technology[30] = array(
	'type'		=> Technology::TYPE_MINING_MODULE,
	'name'		=> 'JunkCollector',
	'weight'	=> 8
);

// ballistic, explosion and energy armor
$technology[40] = array(
	'type'		=> Technology::TYPE_PLATING,
	'name'		=> 'ImpactArmor',
	'weight'	=> 1,
	'stack'		=> 1,
	'armor'		=> 9,
	'craft' => array(	// commodities needed to craft it
		IRON_ID	=> 4
	)
);

/*
 * Ideas:
 *
 * Space-Shotgun (LBX)
 * Rapid fire autocannon (AC), Railgun (EMRG = electromagnetic railgun)
 * vulcan gun (too old fashioned?)
 * Missile Pod
 * Imperium Galactica: Anti-matter ray, Torpedo
 * Gauss Cannon (high energy drain)
 *
 * Burst weapons without ammunition:
 * micro-laser, pulse-laser, quad-laser
 */
$technology[60] = array(
	'type'			=> Technology::TYPE_WEAPON,
	'name'			=> 'SmallBlaster',
	'weight'		=> 1,
	'damage'		=> 11,
	'reload'		=> 3,
	'drain'			=> 4,
	'burst'			=> 3,
	'damageType'	=> Technology::DAMAGE_KINETIC,
	'ammo'			=> BLASTER_AMMUNITION_ID,
	'craft' => array(
		IRON_ID			=> 2,
		ELECTRONICS_ID	=> 1,
		ENERGY_CELLS_ID	=> 1
	)
);
$technology[61] = array(
	'type'			=> Technology::TYPE_WEAPON,
	'name'			=> 'LightLaser',
	'weight'		=> 1,
	'damage'		=> 27,
	'reload'		=> 2,
	'drain'			=> 6,
	'damageType'	=> Technology::DAMAGE_ENERGY,
	'craft' => array(
		IRON_ID			=> 1,
		CRYSTALS_ID		=> 2,
		ENERGY_CELLS_ID => 2
	)
);

$technology[BLASTER_AMMUNITION_ID] = array(
	'type'		=> Technology::TYPE_AMMUNITION,
	'name'		=> 'BlasterAmmunition',
	'weight'	=> 1,
	'stack'		=> 150
);

/*
 * Energy Shield
 * Kinetic Shield
 * Inertia Shield (distortion shield)
 * Magnetic Shield
 * Gravity Shield
 * Deflector Shield
 * Ultra Shield / Awesome Shield
 * Alien Shield
 * Level 2 Alien Shield
 */
$technology[KINETIC_SHIELD_ID] = array(
	'type'		=> Technology::TYPE_SHIELD,
	'name'		=> 'KineticShield',
	'weight'	=> 2,
	'recharge'	=> 1,	// max energy recharge per round
	'buildUp'	=> 10,	// initial energy needed
	'shield'	=> 4,	// "armor" per energy
	'absorb'	=> array(
		Technology::DAMAGE_KINETIC => 2
	)
);

$technology[ENERGY_SHIELD_ID] = array(
	'type'		=> Technology::TYPE_SHIELD,
	'name'		=> 'EnergyShield',
	'weight'	=> 2,
	'recharge'	=> 2,	// max energy recharge per round
	'buildUp'	=> 10,	// initial energy needed
	'shield'	=> 4,	// "armor" per energy
	'absorb'	=> array(
		Technology::DAMAGE_ENERGY => 2
	)
);

$technology[DISTORTION_SHIELD_ID] = array(
	'type'		=> Technology::TYPE_SHIELD,
	'name'		=> 'DistortionShield',
	'weight'	=> 4,
	'recharge'	=> 3,	// max energy recharge per round
	'buildUp'	=> 14,	// initial energy needed
	'shield'	=> 5,	// "armor" per energy
	'absorb'	=> array(
		Technology::DAMAGE_KINETIC => 2,
		Technology::DAMAGE_ENERGY => 2
	)
);

$technology[80] = array(
	'type'		=> Technology::TYPE_REACTOR,
	'name'		=> 'NuclearBatteries',
	'weight'	=> 3,
	'recharge'	=> 4,
	'capacity'	=> 10
);

$technology[90] = array(
	'type'		=> Technology::TYPE_DRIVE,
	'name'		=> 'CombustionDrive',
	'weight'	=> '5',
	'seconds'	=> 7
);
$technology[91] = array(
	'type'		=> Technology::TYPE_DRIVE,
	'name'		=> 'IonDrive',
	'weight'	=> '3',
	'seconds'	=> 7
);
$technology[92] = array(
	'type'		=> Technology::TYPE_DRIVE,
	'name'		=> 'PulseDrive',
	'weight'	=> '5',
	'seconds'	=> 8
);


/*
 * Crafting basic items:
 * craft:	array of [techId => amount] needed to craft it
 * regain:	array of [techId => chance] to regain item on disassembling
 *
 * Implement regain:
 * Everything that is craftable has a 50% regain chance for 50% of the needed resources (floor)
 */
$technology[IRON_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Iron',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 30,
	'craft' => array(
		SPACE_JUNK_ID	=> 1,
		ENERGY_CELLS_ID	=> 1
	),
);
$technology[CRYSTALS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Crystals',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 30
);
$technology[ELECTRONICS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'Electronics',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 30
);
$technology[ENERGY_CELLS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'EnergyCells',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 20
);

$technology[SPACE_JUNK_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'SpaceJunk',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 5,
	'regain' => array(
		IRON_ID			=> array('chance' => 80, 'amount' => 1),
		ELECTRONICS_ID	=> array('chance' => 20, 'amount' => 1)
	)
);
$technology[TECHNICAL_COMPONENTS_ID] = array(
	'type'		=> Technology::TYPE_INGREDIENT,
	'name'		=> 'TechnicalComponents',
	'weight'	=> 1,
	'stack'		=> 1,
	'price'		=> 5,
	'craft' => array(
		IRON_ID			=> 1,
		ELECTRONICS_ID	=> 1
	),
	'regain' => array(
		IRON_ID => array('chance' => 50, 'amount' => 1)
	)
);