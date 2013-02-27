Flasher
=======

[![Build Status](https://travis-ci.org/jjok/Flasher.png)](https://travis-ci.org/jjok/Flasher)

A flash message queue.

	$message_queue = new \jjok\Flasher\Flasher();
	$message_queue->enqueue(new \jjok\Flasher\Messages\Message('This is a message.'));
	$message_queue->enqueue(new \jjok\Flasher\Messages\Message('This is a second message.'));
	
	foreach($message_queue as $message) {
		echo $message;
	}
	// This is a message.
	// This is a second message.

