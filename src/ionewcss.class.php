<?php

/**
 * An IONewcss abstract class
 *
 * This class is needed to create and describe your own commands.
 *
 * @package    IONewcssLibrary
 * @author     Aleksandr Chuprikov <newcsss@gmail.com>
 */

abstract class IONewcss {
	private $name;
	private $description;
	private $arguments = array();
	private $params = array();

	/**
	 * A function that performs logic
	 *
	 * @return string returns the result of the work
	 */
	abstract public function exec();

	/**
	 * Getter. Get command name
	 *
	 * @return string return command name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Setter. Set command name
	 *
	 * @return void no return
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * Setter. Set arguments for exec
	 *
	 * @return void no return
	 */
	public function setArguments( $arguments ) {
		$this->arguments = $arguments;
	}

	/**
	 * Getter. Get array of arguments for exec
	 *
	 * @return array return array of arguments for exec
	 */
	public function getArguments() {
		return $this->arguments;
	}

	/**
	 * Setter. Set parameters for exec
	 *
	 * @return void no return
	 */
	public function setParams( $params ) {
		$this->params = $params;
	}

	/**
	 * Getter. Get array of paramaters for exec
	 *
	 * @return array return array of parameters for exec
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * Getter. Gets the command description
	 *
	 * @return string command description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Setter. Set command description
	 *
	 * @return void no return
	 */
	public function setDescription( $description ) {
		$this->description = $description;
	}
}