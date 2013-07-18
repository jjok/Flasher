<?php

use jjok\Flasher\Messages\Message;
use jjok\Flasher\SessionFlasher;

require '../src/jjok/Flasher/Flasher.php';
require '../src/jjok/Flasher/SessionFlasher.php';
require '../src/jjok/Flasher/Messages/AbstractMessage.php';
require '../src/jjok/Flasher/Messages/Message.php';

session_start();

$message_queue = SessionFlasher::loadFromSession($_SESSION, 'queued_messages');
$message_queue->enqueue(new Message('This is a message that was stored in the session.'));

# Object is destroyed when page reloads
unset($message_queue);

$message_queue = SessionFlasher::loadFromSession($_SESSION, 'queued_messages');

while(!$message_queue->isEmpty()) {
	echo $message_queue->dequeue();
}
