<?php

namespace jjok\Flasher;

use jjok\Flasher\Messages\AbstractMessage;

/**
 * Simple message queue.
 * @package jjok\Flasher
 * @author Jonathan Jefferies (jjok)
 * @version 0.9.0
 */
class Flasher extends \SplQueue {

	/**
	 * (non-PHPdoc)
	 * @see SplQueue::enqueue()
	 * @param AbstractMessage $value
	 */
	public function enqueue(AbstractMessage $value) {
		parent::enqueue($value);
	}

	/**
	 * (non-PHPdoc)
	 * @see SplQueue::dequeue()
	 * @return AbstractMessage
	 */
	public function dequeue() {
		return parent::dequeue();
	}
}
