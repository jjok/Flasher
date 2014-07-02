<?php

namespace jjok\Flasher;

use PHPUnit_Framework_TestCase;

class MessageTest extends PHPUnit_Framework_TestCase {

	/**
	 * @covers \jjok\Flasher\Messages\Message::getType
	 */
	public function testGetTypeGivesTheNameOfTheClass() {
		$error = new \jjok\Flasher\Messages\Message('Some message');
		$this->assertSame('jjok\Flasher\Messages\Message', $error->getType());
	}

	/**
	 * @covers \jjok\Flasher\Messages\Message::__construct
	 * @covers \jjok\Flasher\Messages\Message::__toString
	 */
	public function testConvertingObjectToStringGivesMessage() {
		$error = new \jjok\Flasher\Messages\Message('Some message');
		$this->assertSame('Some message', (string) $error);
	}
}
