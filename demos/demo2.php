<?php

use jjok\Flasher\Messages\Message;

require '../src/jjok/Flasher/Flasher.php';
require '../src/jjok/Flasher/SessionFlasher.php';
require '../src/jjok/Flasher/Messages/AbstractMessage.php';
require '../src/jjok/Flasher/Messages/Message.php';

session_start();

$message_queue = jjok\Flasher\SessionFlasher::loadFromSession($_SESSION, 'something');
$message_queue->enqueue(new Message('This is a message.'));

unset($message_queue);

$message_queue = jjok\Flasher\SessionFlasher::loadFromSession($_SESSION, 'something');

while(!$message_queue->isEmpty()) {
	echo $message_queue->dequeue();
}
