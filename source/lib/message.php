<?php

class Message extends Lisbeth_Entity {
	protected $table = 'messages';

	/**
	 * @param Account $account
	 * @return bool
	 */
	public function isRecipient(Account $account) {
		return ($this->value('recipientId') == $account->id());
	}

	/**
	 * @param Account $sender
	 * @param Account $recipient
	 * @param string $title
	 * @param string $message
	 */
	public static function send(
		Account $sender,
		Account $recipient,
		$title,
		$message
	) {
		$database = new Lisbeth_Database();

		$senderName = $sender->name();
		$senderName = $database->escape($senderName);

		$title = $database->escape($title);
		$message = $database->escape($message);

		$sql = "
			INSERT INTO `messages`
			SET
				`recipientId` = {$recipient->id()},
				`senderId` = {$sender->id()},
				`senderName` = '{$senderName}',
				`title` = '{$title}',
				`message` = '{$message}',
				`created` = UNIX_TIMESTAMP(NOW());";
		$database->query($sql)->freeResult();
	}
}