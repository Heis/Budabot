<?php

namespace Budabot\Core;

use Exception;

class NumberSettingHandler extends SettingHandler {

	public function __construct(DBRow $row) {
		parent::__construct($row);
	}
	
	/**
	 * @return String
	 */
	public function getDescription() {
		$msg = "For this setting you can set any positive integer.\n";
		$msg .= "To change this setting: \n\n";
		$msg .= "<highlight>/tell <myname> settings save {$this->row->name} <i>number</i><end>\n\n";
		return $msg;
	}
	
	/**
	 * @return String
	 */
	public function save($newValue) {
		if (preg_match("/^[0-9]+$/i", $newValue)) {
			return $newValue;
		} else {
			throw new Exception("You must enter a positive integer for this setting.");
		}
	}
}
