<?php

class ActionAcademyTrainingTest extends phpUnitFramework {
	public function testExperience() {
		$this->markTestSkipped('Class has changed');

		$account = $this->mock('Account');
		$sut = new Action_Academy_Training_Abstract($account);

		$experience = 0;
		for ($i = 0; $i < 100; ++$i) {
			$experience += $sut->experience($i);
		}

		$this->assertEquals(
			0,
			$experience
		);
	}
}
