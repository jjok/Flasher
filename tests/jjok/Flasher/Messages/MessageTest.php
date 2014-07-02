<?php

namespace jjok\Flasher;

use PHPUnit_Framework_TestCase;

class ErrorTest extends PHPUnit_Framework_TestCase {

	/**
	 * @covers \jjok\Flasher\Messages\Error::getType
	 */
	public function testGetTypeGivesTheNameOfTheClass() {
		$error = new \jjok\Flasher\Messages\Error('Some error');
		$this->assertSame('jjok\Flasher\Messages\Error', $error->getType());
	}

	/**
	 * @covers \jjok\Flasher\Messages\Error::__construct
	 * @covers \jjok\Flasher\Messages\Error::__toString
	 */
	public function testConvertingObjectToStringGivesMessage() {
		$error = new \jjok\Flasher\Messages\Error('Some error');
		$this->assertSame('Some error', (string) $error);
	}
}
