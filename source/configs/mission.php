<?php

// @TODO Add occurrence chances of events.
// @TODO Add exclusion of same events in a row later?

define('STROLL_AROUND',	1);
define('COLLECT_JUNK',	2);
define('EXPLORATION',	3);
DEFINE('CARRIAGE',		4);

return array(
	STROLL_AROUND => array(
		'name'			=> 'missionStrollAround',
		'actionPoints'	=> 3,
		'events' => array(
			'amount' => '3-5',
			'list' => array(
				array(
					'teaser' => 'missionFoundMoney',
					'reward' => array('money' => '14-53')
				),
				array(
					'teaser' => 'missionTalkedWithPilots',
					'reward' => array('exp' => 3)
				),
				array(
					'teaser' => 'missionThoughtAboutLife',
					'reward' => array('exp' => 4)
				)
			)
		)
	),
	COLLECT_JUNK => array(
		'name'			=> 'missionCollectJunk',
		'actionPoints'	=> 4,	// Needed action points.
		'events' => array(
			'amount' => '2-4',
			'list' => array(
				array(
					'teaser' => 'missionMetWithJunkers',
					'reward' => array('exp' => 4)
				),
				array(
					'teaser' => 'missionBlindedByTheSun',
					'reward' => array('exp' => 7)
				),
				array(
					'teaser' => 'missionFoundSpaceJunk',
					'reward' => array('item' => array(SPACE_JUNK_ID))
				),
				array(
					'teaser' => 'missionFoundEnergyCell',
					'reward' => array('item' => array(ENERGY_CELLS_ID))
				),
				array(
					'teaser' => 'missionFoundElectronics',
					'reward' => array('item' => array(ELECTRONICS_ID))
				)
			)
		)
	),
	EXPLORATION => array(
		'name'			=> 'missionExploration',
		'actionPoints'	=> 8,	// Needed action points.
		'events' => array(
			'amount' => '4-7',
			'list' => array(
				array(
					'teaser' => 'missionSawShootingStar',
					'reward' => array('exp' => 8)
				),
				array(
					'teaser' => 'missionLookingForTheSun',
					'reward' => array('exp' => 9)
				),
				array(
					'teaser' => 'missionSawStardust',
					'reward' => array('exp' => 7)
				),
				array(
					'teaser' => 'missionFoundFloatingJunk',
					'reward' => array('money' => '32-79', 'item' => array(SPACE_JUNK_ID))
				),
				array(
					'teaser' => 'missionWatchingStarships',
					'reward' => array('exp' => 3)
				),
				array(
					'teaser' => 'missionEvadingAsteroid',
					'reward' => array('exp' => 13)
				)
			)
		)
	),
	CARRIAGE => array(
		'name'			=> 'missionCarriage',
		'actionPoints'	=> 9,	// Needed action points.
		'events' => array(
			'amount' => '4-5',
			'list' => array(
				array(
					'teaser' => 'missionDeliverySuccess',
					'reward' => array('money' => '28-153')
				),
				array(
					'teaser' => 'missionDeliveryFailure',
					'reward' => array('exp' => 10)
				)
			)
		),
	)
);