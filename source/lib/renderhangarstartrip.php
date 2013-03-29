<?php

/**
 * Handles space mission rendering.
 */
class RenderHangarStarTrip extends RendererAbstract {

	/**
	 * @return string
	 */
	public function bodyHtml() {
		return $this->starTripActionHtml();
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	public function usesBox() {
		return true;
	}

	/**
	 * @return string
	 */
	protected function starTripActionHtml() {
		$account = $this->account();
		$actionHangarStarTrip = $account->factory()->actionHangarStarTrip();

		$controller = $this->controller();
		if (!$actionHangarStarTrip->canStart()) {
			$controller->redirect(
				$controller->currentRoute(
					array('section' => 'missions')
				)
			);
		}

		$actionHangarStarTrip->start();

		$starTourSeconds = $account->starship()->engine()->starTourSeconds();

		$js = "
			$('#space').engine2d(function (engine2d) {
				init(engine2d, {$starTourSeconds});
			});";
		JavaScript::create()->bind($js);

		$entityLoader = new EntityLoader($account);
		$entityLoader->initSector($starTourSeconds);

		$headline = i18n('starTrip');
		$outOfFuel = i18n('outOfFuel');
		$back = i18n('back');

		$url = $controller->currentRoute(
			array('section' => 'missions')
		);

		return "
			<div id='starTour'>
				<h2>{$headline}</h2>
				<canvas id='space' width='400' height='400'></canvas>
				<div class='finished null'>
					<hr>
					<p class='highlight bold'>{$outOfFuel}</p>
					<a href='{$url}' class='button important'>{$back}</a>
				</div>
				Ladebalken beim einsammeln (Mining Module boost).
				<div id='fps'>frames: 0</div>
			</div>";
	}
}