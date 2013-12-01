<?php

class RenderMessageWrite extends RenderMessageAbstract {
	/**
	 * @return Message|null
	 */
	public function message() {
		$messageId = (int)$this->request()->get('mid');
		if (!$messageId) {
			return null;
		}

		$message = new Message($messageId);
		if (!$message->valid()) {
			return null;
		}

		$account = $this->account();
		if (!$message->isRecipient($account)) {
			return null;
		}

		return $message;
	}

	/**
	 * @return bool
	 */
	public function commit() {
		$request = $this->request();
		if (!$request->post('send')) {
			return false;
		}

		$recipientName = $request->post('recipient');

		/** @var Account $recipient */
		$recipient = Account::blank()->by('name', $recipientName);
		if (!$recipient->valid()) {
			EventBox::get()->failure(
				i18n('recipientNotFound', $recipientName)
			);

			return false;
		}

		if (!Leviathan_Token::getInstance()->valid('token')) {
			return false; // Do not notify about multi-send.
		}

		Message::send(
			$request->post('title'),
			$request->post('message'),
			$recipient,
			$this->account()
		);

		EventBox::get()->success(
			i18n('messageSent')
		);

		return true;
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$sent = $this->commit();

		if (!$sent) {
			$message = $this->message();
			if ($message) {
				$recipientName = $senderName = $message->get('senderName');
				$title = $message->get('title');
				if (strpos($title, 'Re: ') !== 0) {
					$title = 'Re: ' . $title;
				}
				$message = $message->get('message');
				$message = str_replace("\n", "\n> ", $message);
				$message = str_replace("> >", ">>", $message);
				$message = htmlentities($message, null, null, false);
				$message = "\n\n\n\n{$senderName}:\n\n> " . $message;
			}
			else {
				$request = $this->request();
				$recipientName = $request->post('recipient', '');
				$title = $request->post('title', '');
				$message = $request->post('message', '');
			}
		}
		else {
			$recipientName = '';
			$title = '';
			$message = '';
		}

		$token = Leviathan_Token::getInstance()->get();

		return "
			<div id='messageWrite'>
				<h2>{{'write'|i18n}}</h2>
				<div id='messages'>
					<form action='{$_SERVER["REQUEST_URI"]}' method='post'>
						<table class='message'>
							<tr>
								<td>{{'recipient'|i18n}}:</td>
								<td class='right'>
									<input type='text' name='recipient' value='{$recipientName}'
										placeholder=\"{{'recipient'|i18n}}\">
								</td>
							</tr>
							<tr>
								<td>{{'subject'|i18n}}:</td>
								<td class='right'>
									<input type='text' name='title' value='{$title}'
										placeholder=\"{{'subject'|i18n}}\">
								</td>
							</tr>
							<tr>
								<td colspan='2'>
									<textarea name='message'>{$message}</textarea>
								</td>
							</tr>
							<tr>
								<td colspan='2' class='right'>
									<input type='hidden' name='token' value='{$token}'>
									<input type='submit' name='send' class='button' ng-value=\"{{'send'|i18n}}\">
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>";
	}
}