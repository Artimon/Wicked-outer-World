<?php

// @TODO Add occurrence chances of events.
// @TODO Add exclusion of same events in a row later?

define('STROLL_AROUND',	1);
define('COLLECT_JUNK',	2);
define('EXPLORATION',	3);

return array(
	STROLL_AROUND => array(
		'name'			=> 'missionStrollAround',
		'actionPoints'	=> 3,
		'events' => array(
			'amount' => '3-5',
			'list' => array(
				array(
					'teaser' => 'missionFoundMoney',
					'reward' => array('money' => '3-7')
				),
				array(
					'teaser' => 'missionTalkedWithPilots',
					'reward' => array('exp' => 1)
				)
			)
		)
	),
	COLLECT_JUNK => array(
		'name'			=> 'missionCollectJunk',
		'actionPoints'	=> 6,	// Needed action points.
		'events' => array(
			'amount' => '2-4',
			'list' => array(
				array(
					'teaser' => 'missionMetWithJunkers',
					'reward' => array('exp' => 1)
				),
				array(
					'teaser' => 'missionFoundSpaceJunk',
					'reward' => array('item' => array(SPACE_JUNK_ID))
				)
			)
		)
	),
	EXPLORATION => array(
		'name'			=> 'missionExploration',
		'actionPoints'	=> 9,	// Needed action points.
		'events' => array(
			'amount' => '3-7',
			'list' => array(
				array(
					'teaser' => 'missionSawShootingStar',
					'reward' => array('exp' => 1)
				),
				array(
					'teaser' => 'missionLookingForTheSun',
					'reward' => array('exp' => 4)
				),
				array(
					'teaser' => 'missionSawStardust',
					'reward' => array('exp' => 2)
				),
				array(
					'teaser' => 'missionFoundFloatingJunk',
					'reward' => array('money' => '3-7', 'item' => array(SPACE_JUNK_ID))
				),
				array(
					'teaser' => 'missionWatchingStarships',
					'reward' => array('exp' => 3)
				),
				array(
					'teaser' => 'missionEvadingAsteroid',
					'reward' => array('exp' => 6)
				)
			)
		)
	)
);