<?php

use jjok\Flasher\Factory;
use jjok\Flasher\Messages\Message;

require __DIR__.'/../src/jjok/Flasher/Factory.php';
require __DIR__.'/../src/jjok/Flasher/Flasher.php';
require __DIR__.'/../src/jjok/Flasher/SessionFlasher.php';
require __DIR__.'/../src/jjok/Flasher/Messages/AbstractMessage.php';
require __DIR__.'/../src/jjok/Flasher/Messages/Message.php';

session_start();

$factory = new Factory();
$message_queue = $factory->createSessionFlasher($_SESSION, 'queued_messages');
$message_queue->enqueue(new Message('This is a message that was stored in the session.'));

# Object is destroyed when page reloads or something
unset($message_queue);

$message_queue = $factory->createSessionFlasher($_SESSION, 'queued_messages');

while(!$message_queue->isEmpty()) {
	echo $message_queue->dequeue();
}
