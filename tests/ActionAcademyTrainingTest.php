<?php

class ActionAcademyTrainingTest extends phpUnitFramework {
	public function testExperience() {
		$account = $this->mock('Account');
		$sut = new ActionAcademyTraining($account);

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
