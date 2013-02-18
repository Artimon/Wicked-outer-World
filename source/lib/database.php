<?php

class database {
	/**
	 * @var string
	 */
	private $sql;

	/**
	 * @var resource|int|bool
	 */
	private $result;

	/**
	 * @var int
	 */
	private $errorNumber;

	/**
	 * @var string
	 */
	private $errorString;

	/**
	 * @var int
	 */
	private $querys = 0;


	/**
	 * Execute given query.
	 *
	 * @param	string		$sql
	 * @return	database
	 */
	public function query($sql) {
		$this->sql = trim($sql);

		$this->result = mysql_query($this->sql);
		++$this->querys;

		if (false === $this->result) {
			$this->errorNumber = mysql_errno();
			$this->errorString = mysql_error();

//			errorHandler($this->errorNumber, $this->getErrorMessage(), 'class Query', 'N/A');
		} else {
			$this->errorNumber = 0;
			$this->errorString = '';
		}

		return $this;
	}

	/**
	 * Return the current error state.
	 *
	 * @return bool true on error
	 */
	public function hasError() {
		return $this->errorNumber ? true : false;
	}

	/**
	 * Return the sql error message.
	 *
	 * @return string
	 */
	public function getErrorMessage() {
		if ($this->hasError()) {
			return "Anfrage:\n{$this->sql}\nAntwort:\n{$this->errorString}";
		}

		return "Kein Fehler aufgetreten.";
	}

	/**
	 * Return the duplicate check state.
	 *
	 * @return bool true on duplicate entry
	 */
	public function isDuplicate() {
		return (1046 === $this->errorNumber);
	}

	/**
	 * Return the amount of submitted querys.
	 *
	 * @return int
	 */
	public function getQuerys() {
		return $this->querys;
	}

	/**
	 * Return one fetched query result.
	 *
	 * @return array or null on error
	 */
	public function fetch() {
		if ($this->hasError()) {
			return null;
		}

		return @mysql_fetch_assoc($this->result);
	}

	/**
	 * Return mysql num rows.
	 *
	 * @return int
	 */
	public function numRows() {
		if ($this->hasError()) {
			return -1;
		}

		return mysql_num_rows($this->result);
	}

	/**
	 * Frees the mysql result.
	 */
	public function freeResult() {
		if ((false === $this->hasError()) and ($this->result != -1)) {
			mysql_free_result($this->result);
			$this->result = -1;
		}
	}
}