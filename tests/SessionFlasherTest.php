<?php

use jjok\Flasher\SessionFlasher;

require_once 'src/jjok/Flasher/Flasher.php';
require_once 'src/jjok/Flasher/SessionFlasher.php';
#require_once 'dummyAbstractMessage.php';

class SessionFlasherTest extends PHPUnit_Framework_TestCase {

	/**
	 * 
	 * @var jjok\Flasher\Messages\AbstractMessage
	 */
	private $mockMessage;

	public function setUp() {
		$this->mockMessage = new jjok\Flasher\Messages\AbstractMessage();
	}

	public function testFlasherCanBeSavedToSession() {

		$session = array();
		$queue = new SessionFlasher($session, 'abcdef');

		$queue->enqueue($this->mockMessage);
		$queue->saveToSession();

		$this->assertArrayHasKey('abcdef', $session);
		$this->assertCount(1, $session);
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session['abcdef'][0]));
	}

	public function testFlasherIsSavedToSessionWhenDestructed() {

		$mock_message = new jjok\Flasher\Messages\AbstractMessage();
		
		$session = array();
		$queue = new SessionFlasher($session, 'blah');
		
		$queue->enqueue($mock_message);
		
		# Destroy the queue and save to session
		unset($queue);
		
		$this->assertArrayHasKey('blah', $session);
		$this->assertCount(1, $session);
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session['blah'][0]));
	}

	public function testMessagesAreLoadedFromSession() {

		$serialized_message = serialize($this->mockMessage);

		$session = array(
			'something' => array(
				$serialized_message,
				$serialized_message
			),
			'an unrelated thing' => 'test'
		);

		$queue = SessionFlasher::loadFromSession($session, 'something');
		
		$this->assertInstanceOf('jjok\Flasher\SessionFlasher', $queue);

		# Check session has been emptied
		$this->assertCount(1, $session);
		$this->assertArrayNotHasKey('something', $session);
		$this->assertArrayHasKey('an unrelated thing', $session);
		$this->assertEquals('test', $session['an unrelated thing']);

		# Destroy the queue and save to session
		unset($queue);

		$this->assertArrayHasKey('something', $session);
		$this->assertCount(2, $session);
		$this->assertCount(2, $session['something']);
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session['something'][0]));
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session['something'][1]));
	}
}
