<?php

class RenderFightData extends RendererAbstract {
	/**
	 * @var RenderFightData
	 */
	private static $instance;

	/**
	 * @var int
	 */
	private $round = 0;

	/**
	 * @var array
	 */
	private $battleData = array();

	/**
	 * @var array
	 */
	private $tempData = array();

	/**
	 * @var Starship[]
	 */
	private $starships = array();

	/**
	 * @static
	 * @return RenderFightData
	 */
	public static function get() {
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @return array
	 */
	public function battleData() {
		return $this->battleData;
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$result = '';

		foreach ($this->battleData as $roundId => $round) {
				$result .= "
<tr>
	<td colspan='4'>round {$roundId}<hr></td>
</tr>";

			if (isset($round['status'])) {
				foreach ($round['ships'] as $data) {
					$starshipName = html::techLink($data['techId']);

					$inflicted = '';
					if ($data['inflicted']) {
						$inflicted = "
<span class='headline'>({$data['inflicted']})</span>";
					}

					$result .= "
<tr>
	<td>
		<span class='headline'>{$data['ownerName']}</span>:
		{$starshipName}
		{$inflicted}
	</td><td>
		".i18n('partShield').":
		<span class='variable'>{$data['shield']}%</span>
	</td><td>
		".i18n('armor').":
		<span class='variable'>{$data['armor']}%</span>
	</td><td>
		".i18n('internalStructure').":
		<span class='variable'>{$data['structure']}%</span>
	</td>
</tr>";
				}
			} else {
				foreach ($round as $action) {
					$result .= "
<tr>
	<td colspan='3' class='top'>";

					$break = array();
					foreach ($action as $key => $data) {
						if (0 === (int)$key) {
							$result .= $this->actionMessage(
								$data['ownerName'],
								$data['techId'],
								$data['message'],
								$data['class']
							);
						} else {
							$actionInfo = $this->actionInfo(
								$data['message'],
								$data['class'],
								$data['value1'],
								$data['value2']
							);

							if ($data['break']) {
								$break[] = $actionInfo;
							} else {
								$result .= $actionInfo;
							}
						}

					}

					$result .= "
	</td>
	<td class='top'>
		".implode('<br>', $break)."
	</td>
</tr>";
				}
			}
		}

		return html::defaultTable($result);
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
	 * @param string $ownerName
	 * @param int $techId
	 * @param string $message
	 * @param string $class
	 * @return string
	 */
	private function actionMessage(
		$ownerName,
		$techId,
		$message,
		$class
	) {
		$result = "<span class='headline'>{$ownerName}</span>:";

		$value = html::techLink($techId);
		$result .= $this->actionInfo($message, $class, $value);

		return $result;
	}

	/**
	 * @param string $message
	 * @param string $class
	 * @param mixed $value1
	 * @param mixed $value2
	 * @return string
	 */
	private function actionInfo(
		$message,
		$class,
		$value1,
		$value2 = null
	) {
		if ($value2) {
			$value2 = i18n($value2);
		}

		$message = i18n($message, $value1, $value2);

		if ($class) {
			return " <span class='{$class}'>{$message}</span>";
		}

		return ' '.$message;
	}

	public function addStatusData() {
		$data = array(
			'status'	=> true,
			'ships'		=> array()
		);

		/* @var Starship $starship */
		foreach ($this->starships as $starship) {
			$account = $starship->account();
			$condition = $starship->condition();
			$data['ships'][] = array(
				'ownerName'	=> $account->name(),
				'techId'	=> $starship->id(),
				'inflicted'	=> $account->stats()->currentInflictedDamage(),
				'structure'	=> $condition->structurePercentage(),
				'armor'		=> $condition->armorPercentage(),
				'shield'	=> $condition->shieldPercentage()
			);
		}

		$this->battleData[$this->round] = $data;
	}

	/**
	 * @param Account $account
	 * @param Technology $item
	 * @param string $message
	 * @param string $class
	 * @return RenderFightData
	 */
	public function newEvent(
		Account $account,
		Technology $item,
		$message,
		$class = null
	) {
		$this->tempData = array();
		$this->tempData[] = array(
			'ownerName'	=> $account->name(),
			'techId'	=> $item->id(),
			'message'	=> $message,
			'class'		=> $class
		);

		return $this;
	}

	/**
	 * @param string $message
	 * @param string $class
	 * @param mixed $value1
	 * @param mixed $value2
	 * @param bool $break
	 * @return RenderFightData
	 */
	public function addEventInfo(
		$message,
		$class,
		$value1 = null,
		$value2 = null,
		$break = false
	) {
		$this->tempData[] = array(
			'message'	=> $message,
			'class'		=> $class,
			'value1'	=> $value1,
			'value2'	=> $value2,
			'break'		=> $break
		);

		return $this;
	}

	public function commitEvent() {
		$this->battleData[$this->round][] = $this->tempData;
	}

	/**
	 * @param Starship $starship
	 * @return RenderFightData
	 */
	public function addStarship(Starship $starship) {
		$this->starships[] = $starship;

		return $this;
	}

	/**
	 * @return int
	 */
	public function nextRound() {
		return ++$this->round;
	}
}