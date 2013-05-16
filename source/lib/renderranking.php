<?php

class RenderRanking extends RendererAbstract {
	const ROWS = 15;

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$headline = i18n('ranking');
		$description = i18n('ranksDescription');

		$rows = self::ROWS;
		$page = $this->page();
		$offset = $page * $rows;

		$sql = "
			SELECT
				`id`,
				`name`,
				`experience`
			FROM
				`accounts`
			ORDER BY
				`experience` DESC
			LIMIT {$offset}, {$rows};";
		$database = new Lisbeth_Database();
		$results = $database->query($sql)->fetchAll();
		$database->freeResult();

		$rank = i18n('rank');
		$name = i18n('pilot');
		$experience = i18n('experience');

		$html = "
			<tr>
				<th>{$rank}</th>
				<th>{$name}</th>
				<th>{$experience}</th>
			</tr>";

		$accountId = $this->account()->id();

		$number = $offset;
		foreach ($results as $data) {
			++$number;
			$experience = Format::number($data['experience']);

			$class = ($data['id'] == $accountId)
				? " class='push'"
				: '';

			$html .= "
				<tr{$class}>
					<td>{$number}.</td>
					<td>{$data['name']}</td>
					<td class='right'>{$experience}</td>
				</tr>";
		}

		$url = $this->controller()->currentRoute(array(
			'p' => ''
		));

		$prev = $page - 1;
		$leftClass = '';
		if ($offset === 0) {
			$prev = 0;
			$leftClass = ' disabled';
		}

		$next = $page + 1;
		$rightClass = '';
		if (count($results) < $rows) {
			$next = $page;
			$rightClass = ' disabled';
		}

		$html = Html::defaultTable($html) . "
			<hr>
			<div class='center paginator'>
				<a href='{$url}{$prev}' class='entypo-left-open{$leftClass}'></a>
				<a href='{$url}{$next}' class='entypo-right-open{$rightClass}'></a>
			</div>";


		$html = Plugins::box(
			i18n('badBoys'),
			$html
		);

		return "
			<h2>{$headline}</h2>
			<div id='ranks'>
				<div class='column'>
					<p>{$description}</p>
				</div>
				<div class='column'>{$html}</div>
			</div>";
	}

	/**
	 * @return int
	 */
	public function page() {
		$page = $this->request()->get('p');

		if ($page) {
			return max(0, (int)$page);
		}

		$name = $this->account()->name();
		$playerPosition = $this->playerPosition($name);

		return (int)($playerPosition / self::ROWS);
	}

	/**
	 * @param String $name
	 * @return int
	 */
	public function playerPosition($name) {
		$account = Account::blank()->by('name', $name);
		if (!$account->valid()) {
			return 0;
		}

		$database = new Lisbeth_Database();
		$name = $database->escape($name);

		$sql = "
			SELECT
				COUNT(*) AS `position`
			FROM
				`accounts`
			WHERE
				`experience` >= {$account->value('experience')};";
		$position = $database->query($sql)->fetchOne();
		$database->freeResult();

		return (int)$position;
	}

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
}