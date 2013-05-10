<?php

/**
 * Copyright (c) 2013 Jonathan Jefferies
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace jjok\Flasher;

/**
 * A message queue which is automatically saved to the session.
 * @package jjok\Flasher
 * @author Jonathan Jefferies (jjok)
 * @version 1.0.2
 */
class SessionFlasher extends Flasher {

	/**
	 * A reference to the current session.
	 * @var array
	 */
	protected $session;

	/**
	 * The array key used to store queued messages in the session.
	 * @var string
	 */
	protected $namespace;
	
	/**
	 * Set a reference to the session and the session array key.
	 * @param array $session A reference to the session.
	 * @param string $namespace The array key to use when storing in the session.
	 */
	public function __construct(array &$session, $namespace) {
		$this->session =& $session;
		$this->namespace = $namespace;
	}

	/**
	 * Save to the session when queue is destroyed.
	 */
	public function __destruct() {
		$this->saveToSession();
	}

	/**
	 * Load any stored messages from the session and requeue them.
	 * @param array $session A reference to the session.
	 * @param string $namespace The array key to use when storing in the session.
	 * @return \jjok\Flasher\SessionFlasher
	 */
	public static function loadFromSession(array &$session, $namespace) {

		$queue = new static($session, $namespace);

		if(array_key_exists($namespace, $session)) {

			# Re-queue messages
			foreach($session[$namespace] as $message) {
				$queue->enqueue(unserialize($message));
			}
			unset($session[$namespace]);
		}

		return $queue;
	}

	/**
	 * Store all queued messages in the session.
	 */
	public function saveToSession() {
		if(!$this->isEmpty()) {
			$this->session[$this->namespace] = array();
			
			while(!$this->isEmpty()) {
				$this->session[$this->namespace][] = serialize($this->dequeue());
			}
		}
	}
}
