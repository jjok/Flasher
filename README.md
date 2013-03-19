Flasher
=======

[![Build Status](https://travis-ci.org/jjok/Flasher.png)](https://travis-ci.org/jjok/Flasher)

A simple flash message queue.

Examples
--------

Use `jjok\Flasher\Flasher` for a simple message queue.

	// Create a new queue
	$message_queue = new \jjok\Flasher\Flasher();
	
	// Add some messages
	$message_queue->enqueue(new \jjok\Flasher\Messages\Message('This is a message.'));
	$message_queue->enqueue(new \jjok\Flasher\Messages\Message('This is a second message.'));
	
	// Print out each message. (Messages remain queued)
	foreach($message_queue as $message) {
		echo $message;
	}
	
	// "This is a message."
	// "This is a second message."
	
	// OR...
	
	// Dequeue each message. (Empties the queue)
	while(!$message_queue->isEmpty()) {
		echo $message_queue->dequeue();
	}
	
	// "This is a message."
	// "This is a second message."


Use `jjok\Flasher\SessionFlasher` to automatically store queued messages in the session.

	// Start the session
	session_start();
	
	// Get a new message queue, loading any previously queued messages from the session.
	$message_queue = \jjok\Flasher\SessionFlasher::loadFromSession($_SESSION, 'queued_messages');
	
	// Add a message.
	$message_queue->enqueue(new Message('This is a message that was stored in the session.'));
	
	// The page is reloaded.
	unset($message_queue);
	
	$message_queue = \jjok\Flasher\SessionFlasher::loadFromSession($_SESSION, 'queued_messages');
	
	// Dequeue each message
	while(!$message_queue->isEmpty()) {
		echo $message_queue->dequeue();
	}
	
	// "This is a message that was stored in the session."

Run tests
---------

	phpunit
