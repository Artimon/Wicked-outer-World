<?php

class RenderMessageOverview extends RenderMessageAbstract {
	protected function commit(MessagesReceived $messagesReceived) {
		$messageId = (int)$this->request()->get('mid');

		$message = $messagesReceived->entity($messageId);
		if ($message) {
			$messagesReceived->removeEntity($messageId);
			$messagesSent = new MessagesSent(
				$message->get('senderId')
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
				<th colspan='2'>{{'action'|i18n}}</th>
				<th>{{'sender'|i18n}}</th>
				<th>{{'subject'|i18n}}</th>
				<th>{{'stardate'|i18n}}</th>
			</tr>";

		$reply = i18n('reply');
		$delete = i18n('delete');
		$deleteMessage = i18n('deleteMessage');
		$showHideMessage = i18n('showHideMessage');

		$controller = $this->controller();

		foreach ($messagesReceived->messages() as $message) {
			$bold = $message->get('seen')
				? ''
				: " class='bold'";

			$created = date('Y-m-d H:i:s', $message->get('created'));

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

			$title = $message->title();
			$messageText = $message->get('message');
			$senderName = $message->senderName();
			$replyLink = '';

			if ($message->senderId()) {
				$messageText = nl2br($messageText);
				$replyLink = "<a href='{$replyUrl}' class='button'>{{'reply'|i18n}}</a>";
			}
			else {
				$title = "{{'{$title}'|i18n}}";
				$senderName = "{{'{$senderName}'|i18n}}";

				$parts = explode(':', $messageText);
				$messageText = "{{'{$parts[0]}'|i18n:'{$parts[1]}':1}}";
			}

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
							data-seen='{$message->get('seen')}'
							data-url='{$seenUrl}'></span>
					</td>
					<td>{$senderName}</td>
					<td>{$title}</td>
					<td>{$created}</td>
				</tr>
				<tr class='message'>
					<td colspan='5'>
						<hr>
						{$messageText}
						<hr>
						{$replyLink}
						<a href='{$deleteUrl}' class='button deleteMessage'>{{'delete'|i18n}}</a>
					</td>
				</tr>";
		}

		$html = html::defaultTable($html);

		$reallyDeleteMessage = i18n('reallyDeleteMessage');

		JavaScript::create()
			->bind("$('#messages').messageOverview();")
			->bind("$('.deleteMessage').deleteMessage('{$reallyDeleteMessage}')");

		return "
			<h2>{{'messages'|i18n}}</h2>
			<div id='messages'>{$html}</div>";
	}
}