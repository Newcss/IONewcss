<?php

/**
 * An NewcssSumm class
 *
 * This class counts the sum of the arguments passed
 *
 * @package    IONewcssLibrary
 * @author     Aleksandr Chuprikov <newcsss@gmail.com>
 */


class NewcssSumm extends IONewcss {
	/**
	 * This function counts the sum of the arguments passed
	 *
	 * @return void
	 */
	public function exec() {
		$result    = 0;
		$arguments = $this->getArguments();
		foreach ( $arguments as $key => $value ) {
			$result += intval( $value );
		}

		return $result;
	}

	function __construct() {
		$this->setName( "newcssSumm" );
		$this->setDescription( "The function returns the sum of the passed arguments" );
	}
}