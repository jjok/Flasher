<?php

require_once 'src/jjok/Flasher/Messages/AbstractMessage.php';
require_once 'src/jjok/Flasher/Messages/Error.php';

class ErrorTest extends PHPUnit_Framework_TestCase {

	public function testGetTypeGivesTheNameOfTheClass() {
		$error = new \jjok\Flasher\Messages\Error('Some error');
		$this->assertSame('jjok\Flasher\Messages\Error', $error->getType());
	}

	public function testConvertingObjectToStringGivesMessage() {
		$error = new \jjok\Flasher\Messages\Error('Some error');
		$this->assertSame('Some error', (string) $error);
	}
}
