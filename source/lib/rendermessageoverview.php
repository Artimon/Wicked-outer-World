<?php

class RenderMessageOverview extends RenderMessageAbstract {
	protected function commit(MessagesReceived $messagesReceived) {
		$messageId = (int)$this->request()->get('mid');

		$message = $messagesReceived->entity($messageId);
		if ($message) {
			$messagesReceived->removeEntity($messageId);
			$messagesSent = new MessagesSent(
				$message->value('senderId')
			);
			$messagesSent->removeEntity($messageId);
			$message->delete();

			EventBox::get()->success(
				i18n('messageDeleted')
			);
		}
	}

	/**
	 * @return string
	 */
	public function bodyHtml() {
		$messagesReceived = new MessagesReceived(
			$this->account()->id()
		);

		$this->commit($messagesReceived);

		$html = "
			<tr>
				<th colspan='2'>" . i18n('action') . "</th>
				<th>" . i18n('sender') . "</th>
				<th>" . i18n('subject') . "</th>
				<th>" . i18n('stardate') . "</th>
			</tr>";

		$reply = i18n('reply');
		$delete = i18n('delete');
		$deleteMessage = i18n('deleteMessage');
		$showHideMessage = i18n('showHideMessage');

		$controller = $this->controller();

		foreach ($messagesReceived->messages() as $message) {
			$bold = $message->value('seen')
				? ''
				: " class='bold'";

			$created = date('Y-m-d H:i:s', $message->value('created'));

			$messageId = $message->id();
			$deleteUrl = $controller->currentSection(
				array('mid' => $messageId)
			);
			$seenUrl = $controller->currentRoute(array(
				'section' => 'markSeen',
				'mid' => $messageId
			));
			$replyUrl = $controller->currentRoute(array(
				'section' => 'write',
				'mid' => $messageId
			));

			$html .= "
				<tr>
					<td colspan='5'><hr></td>
				</tr>
				<tr{$bold}>
					<td>
						<a href='{$deleteUrl}' class='deleteMessage'>
							<span class='entypo-cancel bold tipTip' title='{$deleteMessage}'></span>
						</a>
					</td>
					<td>
						<span class='entypo-down-open bold tipTip showHideMessage' title='{$showHideMessage}'
							data-seen='{$message->value('seen')}'
							data-url='{$seenUrl}'></span>
					</td>
					<td>{$message->value('senderName')}</td>
					<td>{$message->value('title')}</td>
					<td>{$created}</td>
				</tr>
				<tr class='message'>
					<td colspan='5'>
						<hr>
						{$message->value('message')}
						<hr>
						<a href='{$replyUrl}' class='button'>{$reply}</a>
						<a href='{$deleteUrl}' class='button deleteMessage'>{$delete}</a>
					</td>
				</tr>";
		}

		$html = html::defaultTable($html);

		$messages = i18n('messages');
		$reallyDeleteMessage = i18n('reallyDeleteMessage');

		JavaScript::create()
			->bind("$('#messages').messageOverview();")
			->bind("$('.deleteMessage').deleteMessage('{$reallyDeleteMessage}')");

		return "
			<h2>{$messages}</h2>
			<div id='messages'>{$html}</div>";
	}
}