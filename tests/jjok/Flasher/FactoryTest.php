<?php

namespace jjok\Flasher;

use PHPUnit_Framework_TestCase;

class FactoryTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \jjok\Flasher\Factory::createFlasher
	 */
	public function testFlasherCanBeCreated() {
		$factory = new Factory();
		$this->assertInstanceOf('\jjok\Flasher\Flasher', $factory->createFlasher());
	}
	
	/**
	 * @covers \jjok\Flasher\Factory::createSessionFlasher
	 */
	public function testSessionFlasherCanBeCreated() {
		$factory = new Factory();
// 		$session = array();
		$namespace = 'test';
		
// 		$flasher = $factory->createSessionFlasher($session, 'test');
		
		$mock_message = $this->getMockBuilder('jjok\Flasher\Messages\AbstractMessage')
							 ->disableOriginalConstructor()
							 ->getMock();
		
		$serialized_message = serialize($mock_message);
		
		$session = array(
			$namespace => array(
				$serialized_message,
				$serialized_message
			),
			'an unrelated thing' => 'some value'
		);
		
		$flasher = $factory->createSessionFlasher($session, $namespace);
		
		$this->assertInstanceOf('\jjok\Flasher\SessionFlasher', $flasher);
		
		# Check session has been emptied
		$this->assertCount(1, $session);
		$this->assertArrayNotHasKey($namespace, $session);
		$this->assertArrayHasKey('an unrelated thing', $session);
		$this->assertEquals('some value', $session['an unrelated thing']);
		
		# Destroy the queue and save to session
		unset($flasher);
		
		$this->assertArrayHasKey($namespace, $session);
		$this->assertCount(2, $session);
		$this->assertCount(2, $session[$namespace]);
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session[$namespace][0]));
		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', unserialize($session[$namespace][1]));
	}
}
