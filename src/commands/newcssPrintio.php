<?php

/**
 * An NewcssPrintIO class
 *
 * This class register console command that accepts an unlimited
 * number of arguments and parameters as input and displays them
 * on the screen in a user-readable form.
 *
 * @package    IONewcssLibrary
 * @author     Aleksandr Chuprikov <newcsss@gmail.com>
 */

class NewcssPrintIO extends IONewcss {
	/**
	 * This function displays an unlimited number of arguments and parameters
	 *
	 * @return void
	 */
	public function exec() {
		$result = "Command name: {$this->getName()}\n";
		$result .= "Arguments: \n";
		$result .= print_r( $this->getArguments(), true ) . "\n";
		$result .= "---------------\n";

		$result .= "Parameters: \n";
		$result .= print_r( $this->getParams(), true ) . "\n";
		$result .= "---------------\n";

		return $result;
	}

	function __construct() {
		$this->setName( "newcssPrintIO" );
		$this->setDescription( " The console command that accepts an unlimited number of arguments and parameters as input and displays them on the screen in a user-readable form." );
	}
}