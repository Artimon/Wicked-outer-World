<?php

/**
 * Handles phpunit execution.
 */
class phpunitExecuter {
	private $result = array();

	public function startTest() {
		exec('phpunit', $this->result);
	}

	public function printResult() {
		$title = 'unknown';
		$output = '';
		$startOutput = false;
		$finalLine = count($this->result) - 1;

		foreach ($this->result as $index => $line) {
			if (!$startOutput && 'PHPUnit 3.5.14 by Sebastian Bergmann.' === $line) {
				$startOutput = true;
			}

			if ($startOutput) {
				if ($index === $finalLine) {
					if (false !== strpos($line, 'Failures:')) {
						$title = 'Failures!';
						$output .= "<div class='failures'>{$line}</div>";
					} elseif (false !== strpos($line, 'Skipped:') || false !== strpos($line, 'Incomplete:')) {
						$title = 'Skipped...';
						$output .= "<div class='skipped'>{$line}</div>";
					} else {
						$title = 'OK!';
						$output .= "<div class='ok'>{$line}</div>";
					}
				} else {
					$output .= $line."\n";
				}
			}
		}

		echo "
<style type='text/css'>
body {
	color:LightCyan;
	background-color:black;
}
.failures {
	color:black;
	background-color:red;
}
.skipped {
	color:black;
	background-color:yellow;
}
.ok {
	color:black;
	background-color:lime;
}
</style>
<head>
	<title>{$title}</title>
	<meta http-equiv='refresh' content='2'>
</head>
<body>
	<pre>{$output}</pre>
</body>";
	}
}

$phpUnit = new phpunitExecuter();
$phpUnit->startTest();
$phpUnit->printResult();
