<?php

class AccuracyTest extends phpUnitFramework {
	public function getDataForChance() {
		return array(
			array(50,	1,	1,	1,	1,	87),
			array(0,	1,	1,	1,	1,	95),
			array(100,	1,	1,	1,	1,	50),
			array(85,	1,	1,	1,	1,	64),

			array(50,	1,	2,	1,	1,	90),
			array(50,	2,	1,	1,	1,	90),
			array(50,	2,	2,	1,	1,	93),

			array(50,	10,	25,	10,	10,	95),
			array(50,	25,	10,	10,	10,	95),
			array(50,	25,	25,	10,	10,	95),

			array(50,	1,	1,	1,	2,	84),
			array(50,	1,	1,	2,	1,	84),
			array(50,	1,	1,	2,	2,	81),

			array(50,	10,	10,	10,	25,	65),
			array(50,	10,	10,	25,	10,	65),
			array(50,	10,	10,	25,	25,	52),

			array(50,	10,	10,	10,	10,	87),
			array(50,	10,	10,	10,	10,	87),
			array(50,	10,	10,	10,	10,	87)
		);
	}

	/**
	 * @dataProvider getDataForChance
	 */
	public function testChance(
		$movability,
		$firingLevel,
		$firingTacticsLevel,
		$opponentLevel,
		$opponentDefenseLevel,
		$expectedResult
	) {
		$firingAccount = $this->mock('Account');
		$firingAccount
			->expects($this->once())
			->method('level')
			->will($this->returnValue($firingLevel));
		$firingAccount
			->expects($this->once())
			->method('tacticsLevel')
			->will($this->returnValue($firingTacticsLevel));

		$firingStarship = $this->mock('Starship');
		$firingStarship
			->expects($this->once())
			->method('account')
			->will($this->returnValue($firingAccount));

		$opponentAccount = $this->mock('Account');
		$opponentAccount
			->expects($this->once())
			->method('level')
			->will($this->returnValue($opponentLevel));
		$opponentAccount
			->expects($this->once())
			->method('defenseLevel')
			->will($this->returnValue($opponentDefenseLevel));

		$opponentStarship = $this->mock('Starship');
		$opponentStarship
			->expects($this->once())
			->method('account')
			->will($this->returnValue($opponentAccount));
		$opponentStarship
			->expects($this->once())
			->method('movability')
			->will($this->returnValue($movability));

		$sut = new Accuracy();
		$sut
			->setFiringStarship($firingStarship)
			->setOpponentStarship($opponentStarship);

		$this->assertEquals(
			$expectedResult,
			$sut->chance()
		);
	}
}