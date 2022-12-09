<?php

/**
 * An IONewcssLibrary class
 *
 * This class is needed for registering the necessary commands in the application,
 * executing the specified logic with the ability to output information to the console.
 *
 * @package    IONewcssLibrary
 * @author     Aleksandr Chuprikov <newcsss@gmail.com>
 */

class IONewcssLibrary {
	private const CMD_DIR = "commands";
	private $command;
	private $arguments = array();
	private $params = array();
	private $registered_commands = array();

	/**
	 * Setter. Set command name for exec
	 *
	 * @param string $command a valid name command for exec
	 *
	 * @return void no return
	 */
	private function setCommand( $command ): void {
		$this->command = $command;
	}

	/**
	 * Getter. Get command name for exec
	 *
	 * @return string return command for exec or null if command not set
	 */
	private function getCommand(): string {
		return $this->command;
	}

	/**
	 * Setter. Add new arguments to arguments list
	 *
	 * @return void no return
	 */
	private function setArguments( $argument ): void {
		$this->arguments[] = $argument;
	}

	/**
	 * Getter.  Get an array of arguments
	 *
	 * @return array return array of arguments
	 */
	private function getArguments(): array {
		return $this->arguments;
	}

	/**
	 * Setter. Add new parameter to parameters list
	 *
	 * @return void no return
	 */
	private function setParams( $param ): void {
		$this->params[ $param['key'] ][] = $param['value'];
	}

	/**
	 * Getter.  Get an array of arguments
	 *
	 * @return array return array of arguments
	 */
	private function getParams() {
		return $this->params;
	}

	/**
	 * This function checks for the presence of the passed {help} argument
	 *
	 * @return bool return true if {help} argument is passed to the input
	 */
	public function isHasArgumentsHelp(): bool {
		$arguments_list = $this->getArguments();
		foreach ( $arguments_list as $key => $value ) {
			if ( $value === "help" ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * This function parses input parameters and arguments.
	 *
	 * @param array $args of arguments and parameters
	 * @return void no return
	 */
	private function parseArgs( $args ): void {
		$this->setCommand( $args[1] );
		for ( $i = 2; $i < count( $args ); $i ++ ) {
			// argument
			if ( preg_match( "/{.+}/i", $args[ $i ] ) ) {
				$arg_parsed = explode( ",", substr( $args[ $i ], 1, - 1 ) );
				foreach ( $arg_parsed as $key => $value ) {
					$this->setArguments( $value );
				}
			} // parameter
			else if ( preg_match( "/\[.+\]/i", $args[ $i ] ) ) {
				$param_parsed = explode( "=", substr( $args[ $i ], 1, - 1 ) );
				$param_key    = $param_parsed[0];
				$param_values = explode( ",", $param_parsed[1] );
				foreach ( $param_values as $key => $value ) {
					$this->setParams( array( "key" => $param_key, "value" => $value ) );
				}
			} else {
				throw new Exception( 'Ошибка входных данных' );
			}
		}
	}

	/**
	 * This function scans the command directory and registers them
	 *
	 * @return void no return
	 */
	private function registerCommands(): void {
		$include_files = scandir( self::CMD_DIR );
		foreach ( $include_files as $key => $class_name ) {
			if ( strlen( $class_name ) > 2 ) {
				$class_include = substr( $class_name, 0, - 4 );
				require_once "commands/$class_name";
				$new_command                                          = new $class_include();
				$this->registered_commands[ $new_command->getName() ] = $new_command;
			}
		}

	}

	/**
	 * This function print of list registered command
	 *
	 * @return void no return
	 */
	private function listCommands( $command_name = "" ): void {
		foreach ( $this->registered_commands as $key => $class_name ) {
			if ( $command_name != "" ) {
				if ( $class_name->getName() === $command_name ) {
					echo "{$class_name->getName()} - {$class_name->getDescription()}\n";
				}
			} else {
				echo "{$class_name->getName()} - {$class_name->getDescription()}\n";
			}
		}
	}

	/**
	 * This function print of list passed parameters
	 *
	 * @return void no return
	 */
	private function listParams(): void {

		echo "Command: {$this->getCommand()} \n";
		echo "List arguments: \n";
		print_r( $this->getArguments() );
		echo "\n";

		echo "List params: \n";
		print_r( $this->getParams() );
		echo "\n";
	}


	public
	function __construct(
		$argv
	) {

		try {
			$this->parseArgs( $argv );
		} catch ( Exception $e ) {
			echo 'Поймано исключение: ', $e->getMessage(), "\n";
			exit;
		}

		$this->registerCommands();
		// if no args then return all registered commands
		if ( ! isset( $argv[1] ) ) {
			$this->listCommands();

		} // if we have has argument help
		else if ( $this->isHasArgumentsHelp() ) {
			echo $this->listCommands( $argv[1] );
		} // if we have exec params then run command
		else {

			$this->setCommand( $argv[1] );
			$command_for_exec = $this->registered_commands[ $this->getCommand() ];
			$command_for_exec->setParams( $this->getParams() );
			$command_for_exec->setArguments( $this->getArguments() );
			$result = $command_for_exec->exec();

			echo "Result: {$result}\n";
		}

	}
}