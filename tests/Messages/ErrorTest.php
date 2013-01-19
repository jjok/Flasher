<?php

use jjok\Flasher\Messages\Error;

require_once 'src/jjok/Flasher/Messages/AbstractMessage.php';
require_once 'src/jjok/Flasher/Messages/Error.php';

use jjok\Flasher\Flasher;

class ErrorTest extends PHPUnit_Framework_TestCase {

	public function testGetType() {
		$error = new Error('Some error');
		$this->assertSame('jjok\Flasher\Messages\Error', $error->getType());
	}

	public function testGetError() {
		
	}
}
