<?php

namespace jjok\Flasher;

use PHPUnit_Framework_TestCase;

class SessionFlasherTest extends PHPUnit_Framework_TestCase {

	/**
	 * A mock message.
	 * @var jjok\Flasher\Messages\AbstractMessage
	 */
	private $mockMessage;

	/**
	 * Create a mock message.
	 */
	public function setUp() {
		$this->mockMessage = $this->getMockBuilder('jjok\Flasher\Messages\AbstractMessage')
								  ->disableOriginalConstructor()
								  ->getMock();
	}

	/**
	 * @covers \jjok\Flasher\SessionFlasher::__construct
	 * @covers \jjok\Flasher\SessionFlasher::enqueue
	 * @covers \jjok\Flasher\SessionFlasher::saveToSession
	 */
	public function testFlasherCanBeSavedToSession() {

		$session = array();
		$queue = new \jjok\Flasher\SessionFlasher($session, 'abcdef');

		$queue->enqueue($this->mockMessage);
		$queue->saveToSession();

		$this->assertArrayHasKey('abcdef', $session);
		$this->assertCount(1, $session);
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session['abcdef'][0]));
	}

	/**
	 * @covers \jjok\Flasher\SessionFlasher::__construct
	 * @covers \jjok\Flasher\SessionFlasher::enqueue
	 * @covers \jjok\Flasher\SessionFlasher::__destruct
	 */
	public function testFlasherIsSavedToSessionWhenDestroyed() {
		
		$session = array();
		$queue = new \jjok\Flasher\SessionFlasher($session, 'blah');
		
		$queue->enqueue($this->mockMessage);
		
		# Destroy the queue and save to session
		unset($queue);
		
		$this->assertArrayHasKey('blah', $session);
		$this->assertCount(1, $session);
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session['blah'][0]));
	}
	
	/**
	 * @covers \jjok\Flasher\SessionFlasher::saveToSession
	 */
	public function testFlasherIsNotSavedToSessionIfEmpty() {
		$session = array();
		$queue = new \jjok\Flasher\SessionFlasher($session, 'blah');
		
		# Destroy the queue and save to session
		unset($queue);
		
		$this->assertArrayNotHasKey('blah', $session);
		$this->assertCount(0, $session);
	}

	/**
	 * @covers \jjok\Flasher\SessionFlasher::loadFromSession
	 * @covers \jjok\Flasher\SessionFlasher::__destruct
	 */
	public function testMessagesAreLoadedFromSession() {

		$serialized_message = serialize($this->mockMessage);

		$session = array(
			'something' => array(
				$serialized_message,
				$serialized_message
			),
			'an unrelated thing' => 'test'
		);

		$queue = \jjok\Flasher\SessionFlasher::loadFromSession(
			$session,
			'something'
		);
		
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
