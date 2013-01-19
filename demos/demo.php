<?php

use jjok\Flasher\Messages\Message;

require '../src/jjok/Flasher/Flasher.php';
require '../src/jjok/Flasher/Messages/AbstractMessage.php';
require '../src/jjok/Flasher/Messages/Message.php';

$message_queue = new jjok\Flasher\Flasher();
$message_queue->enqueue(new Message('This is a message.'));

foreach($message_queue as $message) {
	echo $message;
}
