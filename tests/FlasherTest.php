<?php

require_once 'src/jjok/Flasher/Flasher.php';
require_once 'src/jjok/Flasher/Messages/AbstractMessage.php';

class FlasherTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \jjok\Flasher\Flasher::enqueue
	 * @covers \jjok\Flasher\Flasher::dequeue
	 */
	public function testMessagesCanBeQueuedAndDequeued() {
		$mock_message = $this->getMockBuilder('jjok\Flasher\Messages\AbstractMessage')
                     ->disableOriginalConstructor()
                     ->getMock();
		
		$queue = new \jjok\Flasher\Flasher();
		$this->assertTrue($queue->isEmpty(), 'Queue should start empty.');
		
		# Queue message
		$queue->enqueue($mock_message);

		$this->assertFalse($queue->isEmpty(), 'Queue should not be empty after message has been queued.');
		$this->assertSame(1, $queue->count(), 'Queue length should be 1 after queuing 1 message.');

		# Queue message
		$queue->enqueue($mock_message);

		$this->assertSame(2, $queue->count(), 'Queue length should be 2 after queuing 2 messages.');

		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', $queue->dequeue());
		$this->assertSame(1, $queue->count(), 'Queue length should be 1 after dequeuing 1 message.');

		$this->assertInstanceOf('jjok\Flasher\Messages\AbstractMessage', $queue->dequeue());
		$this->assertTrue($queue->isEmpty(), 'Queue should be empty after dequeuing all messages.');
	}
}
