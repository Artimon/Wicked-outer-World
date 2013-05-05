<?php

class MessagesSent extends Lisbeth_Collection {
	protected $table = 'messages';
	protected $group = 'senderId';
	protected $order = 'id DESC';
	protected $entityName = 'Message';

	/**
	 * @return Message[]
	 */
	public function messages() {
		return $this->entities();
	}
}