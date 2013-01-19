<?php

namespace jjok\Flasher\Messages;

/**
 * 
 * @package jjok\Flasher
 * @subpackage jjok\Flasher\Messages
 * @author Jonathan Jefferies
 * @version 0.9.0
 */
abstract class AbstractMessage {

	/**
	 * The message.
	 * @var string
	 */
	protected $message;

	/**
	 * Set the message.
	 * @param string $message The message.
	 */
	public function __construct($message) {
		$this->message = $message;
	}

	/**
	 * Get the message.
	 * @return string
	 */
	public function __toString() {
		return $this->message;
	}

	/**
	 * Get the type of message.
	 * @return string
	 */
	public function getType() {
		return get_class($this);
	}
}
