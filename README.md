Flasher
=======

[![Latest Stable Version](https://poser.pugx.org/jjok/flasher/v/stable.png)](https://packagist.org/packages/jjok/flasher)
[![Build Status](https://travis-ci.org/jjok/Flasher.png)](https://travis-ci.org/jjok/Flasher)

A simple flash message queue.

Examples
--------

Use `jjok\Flasher\Flasher` for a simple message queue.

	use jjok\Flasher\Flasher;
	use jjok\Flasher\Messages\Message;
	
	// Create a new queue
	$message_queue = new Flasher();
	
	// Add some messages
	$message_queue->enqueue(new Message('This is a message.'));
	$message_queue->enqueue(new Message('This is a second message.'));
	
	// Print out each message. (Messages remain queued)
	foreach($message_queue as $message) {
		echo $message;
	}
	
	// "This is a message."
	// "This is a second message."

or

	// Dequeue each message. (Empties the queue)
	while(!$message_queue->isEmpty()) {
		echo $message_queue->dequeue();
	}
	
	// "This is a message."
	// "This is a second message."


Use `jjok\Flasher\SessionFlasher` to automatically store queued messages in the session.

	use jjok\Flasher\Factory;
	use jjok\Flasher\Messages\Message;
	
	// Start the session
	session_start();
	
	$factory = new Factory();
	
	// Get a new message queue, loading any previously queued messages from the session.
	$message_queue = $factory->createSessionFlasher($_SESSION, 'queued_messages');
	
	// Add a message.
	$message_queue->enqueue(new Message('This is a message that was stored in the session.'));
	
	// The page is reloaded, or redirects before messages are shown.
	unset($message_queue);
	
	$message_queue = $factory->createSessionFlasher($_SESSION, 'queued_messages');
	
	// Dequeue each message
	while(!$message_queue->isEmpty()) {
		echo $message_queue->dequeue();
	}
	
	// "This is a message that was stored in the session."

Run tests
---------

	php -r readfile("https://phar.phpunit.de/phpunit.phar"); > phpunit.phar
	php phpunit.phar

TODO
----

- [ ] Add MessageFactory class.


Copyright (c) 2014 Jonathan Jefferies
