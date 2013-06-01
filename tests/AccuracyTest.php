<?php

class AccuracyTest extends phpUnitFramework {
	public function getDataForChance() {
		return array(
			array(50,	1,	1,	1,	1,	74),
			array(0,	1,	1,	1,	1,	95),
			array(100,	1,	1,	1,	1,	5),
			array(85,	1,	1,	1,	1,	27),

			array(50,	1,	2,	1,	1,	77),
			array(50,	2,	1,	1,	1,	77),
			array(50,	2,	2,	1,	1,	79),

			array(50,	10,	25,	10,	10,	95),
			array(50,	25,	10,	10,	10,	95),
			array(50,	25,	25,	10,	10,	95),

			array(50,	1,	1,	1,	2,	71),
			array(50,	1,	1,	2,	1,	71),
			array(50,	1,	1,	2,	2,	69),

			array(50,	10,	10,	10,	25,	55),
			array(50,	10,	10,	25,	10,	55),
			array(50,	10,	10,	25,	25,	44),

			array(50,	10,	10,	10,	10,	74),
			array(50,	10,	10,	10,	10,	74),
			array(50,	10,	10,	10,	10,	74)
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