<?php

class Message extends Lisbeth_Entity_Messages {
	/**
	 * @param Account $account
	 * @return bool
	 */
	public function isRecipient(Account $account) {
		return ($this->get('recipientId') == $account->id());
	}

	/**
	 * @param string $title
	 * @param string $message
	 * @param Account $recipient
	 * @param Account|null $sender
	 */
	public static function send(
		$title,
		$message,
		Account $recipient,
		Account $sender = null
	) {
		$database = new Lisbeth_Database();

		$senderId = 0;
		$senderName = 'battleSystem';

		if ($sender) {
			$senderId = $sender->id();
			$senderName = $sender->name();
		}

		self::create(array(
			'recipientId' => $recipient->id(),
			'senderId' => $senderId,
			'senderName' => $senderName,
			'title' => $title,
			'message' => $message,
			'created' => TIME
		));
	}
}