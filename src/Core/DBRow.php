<?php

namespace Budabot\Core;

class DBRow {
	public function __get($value) {
		$logger = new LoggerWrapper('DB');
		$logger->log('WARN', "Tried to get value '$value' from row that doesn't exist");
	}
}
