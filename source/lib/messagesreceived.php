<?php

class MessagesReceived extends Lisbeth_Collection {
	protected $table = 'messages';
	protected $group = 'recipientId';
	protected $order = 'id DESC';
	protected $entityName = 'Message';

	/**
	 * @return Message[]
	 */
	public function messages() {
		return $this->entities();
	}
}