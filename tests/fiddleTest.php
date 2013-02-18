<?php

class fiddleTest extends phpUnitFramework {
	public function testFiddling() {
		$fiddle = $this->mock('fiddle', array('create'));
		$stockage = $this->mock('stockage');

		// Correct order and amount (ok)
		$techId = $fiddle
			->start()
			->addIngredient(SPACE_JUNK_ID, 1)
			->addIngredient(ENERGY_CELLS_ID, 1)
			->commit($stockage);
		$this->assertEquals(IRON_ID, $techId);

		// Correct amount but miss-ordered (ok)
		$techId = $fiddle
			->start()
			->addIngredient(ENERGY_CELLS_ID, 1)
			->addIngredient(SPACE_JUNK_ID, 1)
			->commit($stockage);
		$this->assertEquals(IRON_ID, $techId);

		// Correct order but wrong amount (fail)
		$techId = $fiddle
			->start()
			->addIngredient(SPACE_JUNK_ID, 1)
			->addIngredient(ENERGY_CELLS_ID, 2)
			->commit($stockage);
		$this->assertNull($techId);

		// Missing ingredient (fail)
		$techId = $fiddle
			->start()
			->addIngredient(SPACE_JUNK_ID, 1)
			->commit($stockage);
		$this->assertNull($techId);
	}
}