<?php

require_once 'src/jjok/Flasher/Flasher.php';
require_once 'src/jjok/Flasher/Messages/AbstractMessage.php';
require_once 'TestMessage.php';

class FlasherTest extends PHPUnit_Framework_TestCase {
	
	public function testQueuing() {
		$mock_message = new TestMessage('test');
		$queue = new \jjok\Flasher\Flasher();
		$this->assertTrue($queue->isEmpty());
		
		# Queue message
		$queue->enqueue($mock_message);

		$this->assertFalse($queue->isEmpty());
		$this->assertSame(1, $queue->count());

		# Queue message
		$queue->enqueue($mock_message);

		$this->assertSame(2, $queue->count());

		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', $queue->dequeue());
		$this->assertSame(1, $queue->count());

		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', $queue->dequeue());
		$this->assertTrue($queue->isEmpty());
	}
}
