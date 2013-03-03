<?php

/**
 * Calculates a given mission and provides it's result.
 */
class ActionHangarMission extends ActionAbstract {
	/**
	 * @var int
	 */
	private $missionId;

	/**
	 * @return stdClass
	 */
	public function config() {
		return Config::getInstance()->missions();
	}

	/**
	 * @return array
	 */
	public function currentMission() {
		$config = $this->config();

		return $config->missions[$this->missionId];
	}

	/**
	 * @param int $missionId
	 * @return ActionHangarMission
	 * @throws InvalidArgumentException
	 */
	public function load($missionId) {
		$this->missionId = (int)$missionId;

		$config = $this->config();
		if (!array_key_exists($missionId, $config->missions)) {
			$message = "Mission ID '{$missionId}' unknown.";
			throw new InvalidArgumentException($message);
		}

		return $this;
	}

	/**
	 * @param string $range
	 * @return int
	 */
	public function randomValue($range) {
		$value = explode('-', $range);

		return (int)rand($value[0], $value[1]);
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function start() {
		if (!$this->canStart()) {
			throw new Exception('Mission cannot be started.');
		}

		$mission = $this->currentMission();
		$events = $mission['events'];
		$amount = $this->randomValue($events['amount']);

		$account = $this->account();
		$account->incrementActionPoints(-$mission['actionPoints']);

		$result = array();
		while ($amount-- > 0) {
			$index = array_rand($events['list']);
			$event = $events['list'][$index];

			$reward = array_rand($event['reward']);
			$value = $event['reward'][$reward];

			switch ($reward) {
				case 'exp':
					$account->increment('experience', $value);
					break;

				case 'money':
					$value = $this->randomValue($value);
					$account->increment('money', $value);
					break;

				case 'item':
					foreach ($value as $techId) {
						$item = Technology::raw($techId);
						echo $item->name();
					}
					break;

				default:
					continue 2;
			}

			$result[] = i18n($event['teaser'], $value);
		}

		$account->update();

		$result[] = i18n('missionSuccess');

		return json_encode($result);
	}

	/**
	 * @return bool
	 */
	public function canStart() {
		$actionPoints = $this->account()->actionPoints();
		$data = $this->currentMission();

		return ($actionPoints >= $data['actionPoints']);
	}
}
