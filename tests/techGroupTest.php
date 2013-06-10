<?php

class techGroupTest extends phpUnitFramework {
	/**
	 * @dataProvider getDataForLoadableAmount
	 */
	public function testLoadableAmount(
		$availableTonnage,
		$weight,
		$stackSize,
		$hasItem,
		$stackGap,
		$expectedAmount
	) {
		$item = $this->mock('Technology');
		$item
			->expects($this->once())
			->method('weight')
			->will($this->returnValue($weight));
		$item
			->expects($this->once())
			->method('stackSize')
			->will($this->returnValue($stackSize));
		$item
			->expects($this->any())
			->method('stackGap')
			->will($this->returnValue($stackGap));

		$techContainer = $this->mock('TechContainerAbstract');
		$techContainer
			->expects($this->once())
			->method('availableTonnage')
			->will($this->returnValue($availableTonnage));

		$techGroup = $this->mock('techGroup', array('techContainer', 'hasItem'));
		$techGroup
			->expects($this->once())
			->method('techContainer')
			->will($this->returnValue($techContainer));
		$techGroup
			->expects($this->once())
			->method('hasItem')
			->will($this->returnValue($hasItem));

		$amount = $techGroup->loadableAmount($item);
		$this->assertEquals(
			$expectedAmount,
			$amount
		);
	}

	public function getDataForLoadableAmount() {
		return array(
			array(10,	2,	1,	false,	null,	5),
			array(9,	2,	1,	false,	null,	4),
			array(0,	2,	1,	false,	null,	0),
			array(10,	2,	5,	true,	0,		25),
			array(10,	2,	5,	true,	5,		30),
			array(9,	2,	5,	true,	0,		20),
			array(9,	2,	5,	true,	5,		25),
			array(0,	2,	5,	true,	0,		0),
			array(0,	2,	5,	true,	5,		5)
		);
	}
}