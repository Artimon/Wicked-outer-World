<?php

class RenderSkirmishFight extends RendererAbstract {
	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	/**
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}

	public function bodyHtml() {
		$opponentId = (int)$this->request()->get('attack');
		$opponent = ObjectPool::get()->account($opponentId);

		$controller = $this->controller();
		$url = $controller->section('skirmish');

		if (!$opponent->valid()) {
			$controller->redirect($url);
		}

		$account = $this->account();
		$difference = $account->level() - $opponent->level();
		if ($difference > ActionSkirmishOpponents::LEVEL_DIFFERENCE) {
			$controller->redirect($url);
		}

		$fight = new ActionFight($account);
		$fight
			->setAggressor($account->starship())
			->setVictim($opponent->starship());

		if (!$fight->canStart()) {
			$controller->redirect($url);
		}

		$fightResultText = $fight->start();
		$jsonResult = $fight->jsonData();

//		$result = '[{"s":"victim","a":"su","m":"shieldUp","d":750,"v":0,"ag":{"c":100,"s":0,"e":100},"vi":{"c":100,"s":100,"e":0}},{"s":"victim","a":"d","m":"nameLightLaser","d":750,"v":26,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":35,"e":0}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":35,"e":40}},{"s":"victim","a":"sp","m":"shieldPlus","d":750,"v":4,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":45,"e":30}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":100,"s":0,"e":80},"vi":{"c":100,"s":45,"e":30}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":45,"e":30}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":45,"e":30}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":750,"v":0,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":45,"e":30}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":45,"e":70}},{"s":"victim","a":"sp","m":"shieldPlus","d":750,"v":4,"ag":{"c":100,"s":0,"e":40},"vi":{"c":100,"s":55,"e":60}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":100,"s":0,"e":80},"vi":{"c":100,"s":55,"e":60}},{"s":"victim","a":"d","m":"nameLightLaser","d":0,"v":26,"ag":{"c":100,"s":0,"e":20},"vi":{"c":95,"s":0,"e":60}},{"s":"victim","a":"sd","m":"shieldDown","d":750,"v":0,"ag":{"c":100,"s":0,"e":20},"vi":{"c":95,"s":0,"e":60}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":100,"s":0,"e":20},"vi":{"c":95,"s":0,"e":100}},{"s":"aggressor","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":100,"s":0,"e":20},"vi":{"c":95,"s":0,"e":60}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":350,"v":10,"ag":{"c":91,"s":0,"e":20},"vi":{"c":95,"s":0,"e":60}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":750,"v":11,"ag":{"c":81,"s":0,"e":20},"vi":{"c":95,"s":0,"e":60}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":81,"s":0,"e":60},"vi":{"c":95,"s":0,"e":60}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":81,"s":0,"e":20},"vi":{"c":95,"s":0,"e":60}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":350,"v":12,"ag":{"c":81,"s":0,"e":20},"vi":{"c":78,"s":0,"e":60}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":750,"v":11,"ag":{"c":81,"s":0,"e":20},"vi":{"c":63,"s":0,"e":60}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":81,"s":0,"e":20},"vi":{"c":63,"s":0,"e":100}},{"s":"victim","a":"su","m":"shieldUp","d":750,"v":0,"ag":{"c":81,"s":0,"e":20},"vi":{"c":63,"s":100,"e":0}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":81,"s":0,"e":60},"vi":{"c":63,"s":100,"e":0}},{"s":"victim","a":"m","m":"nameLightLaser","d":750,"v":0,"ag":{"c":81,"s":0,"e":0},"vi":{"c":63,"s":100,"e":0}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":81,"s":0,"e":0},"vi":{"c":63,"s":100,"e":40}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":81,"s":0,"e":40},"vi":{"c":63,"s":100,"e":40}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":81,"s":0,"e":0},"vi":{"c":63,"s":100,"e":40}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":350,"v":10,"ag":{"c":81,"s":0,"e":0},"vi":{"c":63,"s":75,"e":40}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":750,"v":9,"ag":{"c":81,"s":0,"e":0},"vi":{"c":63,"s":53,"e":40}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":81,"s":0,"e":0},"vi":{"c":63,"s":53,"e":80}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":350,"v":11,"ag":{"c":71,"s":0,"e":0},"vi":{"c":63,"s":53,"e":40}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":350,"v":11,"ag":{"c":60,"s":0,"e":0},"vi":{"c":63,"s":53,"e":40}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":750,"v":12,"ag":{"c":49,"s":0,"e":0},"vi":{"c":63,"s":53,"e":40}},{"s":"victim","a":"sp","m":"shieldPlus","d":750,"v":4,"ag":{"c":49,"s":0,"e":0},"vi":{"c":63,"s":63,"e":30}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":49,"s":0,"e":40},"vi":{"c":63,"s":63,"e":30}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":49,"s":0,"e":0},"vi":{"c":63,"s":63,"e":30}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":350,"v":11,"ag":{"c":49,"s":0,"e":0},"vi":{"c":63,"s":35,"e":30}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":750,"v":9,"ag":{"c":49,"s":0,"e":0},"vi":{"c":63,"s":13,"e":30}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":49,"s":0,"e":0},"vi":{"c":63,"s":13,"e":70}},{"s":"victim","a":"sp","m":"shieldPlus","d":750,"v":4,"ag":{"c":49,"s":0,"e":0},"vi":{"c":63,"s":23,"e":60}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":49,"s":0,"e":40},"vi":{"c":63,"s":23,"e":60}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":49,"s":0,"e":40},"vi":{"c":63,"s":23,"e":100}},{"s":"victim","a":"sp","m":"shieldPlus","d":750,"v":4,"ag":{"c":49,"s":0,"e":40},"vi":{"c":63,"s":33,"e":90}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":49,"s":0,"e":80},"vi":{"c":63,"s":33,"e":90}},{"s":"victim","a":"d","m":"nameLightLaser","d":0,"v":26,"ag":{"c":49,"s":0,"e":20},"vi":{"c":44,"s":0,"e":90}},{"s":"victim","a":"sd","m":"shieldDown","d":750,"v":0,"ag":{"c":49,"s":0,"e":20},"vi":{"c":44,"s":0,"e":90}},{"s":"victim","a":"r","m":"recharge","d":750,"v":1,"ag":{"c":49,"s":0,"e":20},"vi":{"c":44,"s":0,"e":100}},{"s":"aggressor","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":49,"s":0,"e":20},"vi":{"c":44,"s":0,"e":60}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":350,"v":12,"ag":{"c":39,"s":0,"e":20},"vi":{"c":44,"s":0,"e":60}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":750,"v":11,"ag":{"c":29,"s":0,"e":20},"vi":{"c":44,"s":0,"e":60}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":29,"s":0,"e":60},"vi":{"c":44,"s":0,"e":60}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":29,"s":0,"e":20},"vi":{"c":44,"s":0,"e":60}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":350,"v":11,"ag":{"c":29,"s":0,"e":20},"vi":{"c":28,"s":0,"e":60}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":750,"v":11,"ag":{"c":29,"s":0,"e":20},"vi":{"c":11,"s":0,"e":60}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":29,"s":0,"e":20},"vi":{"c":11,"s":0,"e":100}},{"s":"victim","a":"su","m":"shieldUp","d":750,"v":0,"ag":{"c":29,"s":0,"e":20},"vi":{"c":11,"s":100,"e":0}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":29,"s":0,"e":60},"vi":{"c":11,"s":100,"e":0}},{"s":"victim","a":"d","m":"nameLightLaser","d":750,"v":26,"ag":{"c":29,"s":0,"e":0},"vi":{"c":11,"s":35,"e":0}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":29,"s":0,"e":0},"vi":{"c":11,"s":35,"e":40}},{"s":"victim","a":"sp","m":"shieldPlus","d":750,"v":4,"ag":{"c":29,"s":0,"e":0},"vi":{"c":11,"s":45,"e":30}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":29,"s":0,"e":40},"vi":{"c":11,"s":45,"e":30}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":29,"s":0,"e":0},"vi":{"c":11,"s":45,"e":30}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":350,"v":7,"ag":{"c":29,"s":0,"e":0},"vi":{"c":11,"s":28,"e":30}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":750,"v":9,"ag":{"c":29,"s":0,"e":0},"vi":{"c":11,"s":5,"e":30}},{"s":"victim","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":29,"s":0,"e":0},"vi":{"c":11,"s":5,"e":70}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":350,"v":10,"ag":{"c":20,"s":0,"e":0},"vi":{"c":11,"s":5,"e":30}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":350,"v":11,"ag":{"c":11,"s":0,"e":0},"vi":{"c":11,"s":5,"e":30}},{"s":"aggressor","a":"d","m":"nameSmallBlaster","d":750,"v":11,"ag":{"c":1,"s":0,"e":0},"vi":{"c":11,"s":5,"e":30}},{"s":"victim","a":"sp","m":"shieldPlus","d":750,"v":4,"ag":{"c":1,"s":0,"e":0},"vi":{"c":11,"s":15,"e":20}},{"s":"aggressor","a":"r","m":"recharge","d":750,"v":4,"ag":{"c":1,"s":0,"e":40},"vi":{"c":11,"s":15,"e":20}},{"s":"victim","a":"m","m":"nameSmallBlaster","d":350,"v":0,"ag":{"c":1,"s":0,"e":0},"vi":{"c":11,"s":15,"e":20}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":0,"v":11,"ag":{"c":1,"s":0,"e":0},"vi":{"c":3,"s":0,"e":20}},{"s":"victim","a":"sd","m":"shieldDown","d":350,"v":0,"ag":{"c":1,"s":0,"e":0},"vi":{"c":3,"s":0,"e":20}},{"s":"victim","a":"d","m":"nameSmallBlaster","d":750,"v":11,"ag":{"c":1,"s":0,"e":0},"vi":{"c":0,"s":0,"e":20}}]';
		$translations = ActionFight::jsonTranslations($jsonResult);
		$initial = Initial::get();
		$js = "$('#fightContainer').animateFight(
			'{$jsonResult}',
			'{$translations}',
			{$initial->condition()},
			{$initial->money()}
		);";
		JavaScript::create()->bind($js);

		$attackerBars = $account->bars();
		$victimBars = $opponent->bars();

		$headline = i18n('fight');
		$shipCondition = i18n('shipCondition');
		$shields = i18n('partShield');
		$energy = i18n('energy');

		return "
			<h2>{$headline}</h2>
			<div id='skirmish'>
				<div id='fightContainer'>
					<div class='fighter aggressor'>
						<p class='h2 highlight'>{$account->name()}</p>

						<div class='label condition'>
							{$shipCondition}<br>
							{$attackerBars->conditionBar()}
						</div>

						<div class='label shield'>
							{$shields}<br>
							{$attackerBars->shieldBar()}
						</div>

						<div class='label energy'>
							{$energy}<br>
							{$attackerBars->energyBar()}
						</div>

						<div class='actionContainer'></div>
					</div>
					<div class='fighter victim'>
						<p class='h2 highlight'>{$opponent->name()}</p>

						<div class='label condition'>
							{$shipCondition}<br>
							{$victimBars->conditionBar()}
						</div>

						<div class='label shield'>
							{$shields}<br>
							{$victimBars->shieldBar()}
						</div>

						<div class='label energy'>
							{$energy}<br>
							{$victimBars->energyBar()}
						</div>

						<div class='actionContainer'></div>
					</div>
					<div class='fightResult null'>
						<hr>
						<p class='h2 critical'>{$fightResultText}</p>
					</div>
				</div>
			</div>";
	}
}
