<?php

namespace jjok\Flasher;

/**
 * A message queue which is automatically saved to the session.
 * @package jjok\Flasher
 * @author Jonathan Jefferies (jjok)
 * @version 0.9.0
 */
class SessionFlasher extends Flasher {

	/**
	 * A reference to the current session.
	 * @var array
	 */
	protected $session;

	/**
	 * 
	 * @var string
	 */
	protected $namespace;
	
	/**
	 * 
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
		$this->session[$this->namespace] = array();
		while(!$this->isEmpty()) {
			$this->session[$this->namespace][] = serialize($this->dequeue());
		}
	}
}
