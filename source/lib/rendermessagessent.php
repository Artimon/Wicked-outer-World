<?php

class RenderMessagesSent extends RenderMessageAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$messagesSent = new MessagesSent(
			$this->account()->id()
		);

		$html = "
			<tr>
				<th>" . i18n('recipient') . "</th>
				<th>" . i18n('subject') . "</th>
				<th>" . i18n('stardate') . "</th>
			</tr>";

		foreach ($messagesSent->messages() as $message) {
			$account = ObjectPool::get()->account(
				$message->get('recipientId')
			);
			$recipientName = $account->valid()
				? $account->name()
				: '-';

			$bold = $message->get('seen')
				? ''
				: " class='bold'";

			$created = date('Y-m-d H:i:s', $message->get('created'));

			$html .= "
				<tr>
					<td colspan='5'><hr></td>
				</tr>
				<tr{$bold}>
					<td>{$recipientName}</td>
					<td>{$message->get('title')}</td>
					<td>{$created}</td>
				</tr>
				<tr class='message'>
					<td colspan='5'>
						<hr>
						{$message->get('message')}
					</td>
				</tr>";
		}

		$html = html::defaultTable($html);

		$sent = i18n('sent');

		JavaScript::create()
			->bind("$('#messages').messageOverview();");

		return "
			<h2>{$sent}</h2>
			<div id='messages'>{$html}</div>";
	}
}