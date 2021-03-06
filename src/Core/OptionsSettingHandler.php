<?php

namespace Budabot\Core;

use Exception;

class OptionsSettingHandler extends SettingHandler {

	public function __construct(DBRow $row) {
		parent::__construct($row);
	}

	/**
	 * @return String
	 */
	public function getDescription() {
		$msg = "For this setting you must choose one of the options from the list below.\n\n";
		return $msg;
	}

	/**
	 * @return String of new value or false if $newValue is invalid
	 */
	public function save($newValue) {
		$options = explode(";", $this->row->options);
		if ($this->row->intoptions != '') {
			$intoptions = explode(";", $this->row->intoptions);
			if (in_array($newValue, $intoptions)) {
				return $newValue;
			} else {
				throw new Exception("This is not a correct option for this setting.");
			}
		} else {
			if (in_array($newValue, $options)) {
				return $newValue;
			} else {
				throw new Exception("This is not a correct option for this setting.");
			}
		}
	}
}
