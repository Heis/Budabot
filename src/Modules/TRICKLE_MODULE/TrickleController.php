<?php

namespace Budabot\Modules\TRICKLE_MODULE;

/**
 * @author Tyrence (RK2)
 *
 * @Instance
 *
 * Commands this controller contains:
 *	@DefineCommand(
 *		command     = 'trickle',
 *		accessLevel = 'all',
 *		description = 'Shows how much skills you will gain by increasing an ability',
 *		help        = 'trickle.txt'
 *	)
 */
class TrickleController {

	/**
	 * Name of the module.
	 * Set automatically by module loader.
	 */
	public $moduleName;

	/**
	 * @var \Budabot\Core\Text $text
	 * @Inject
	 */
	public $text;
	
	/**
	 * @var \Budabot\Core\Util $util
	 * @Inject
	 */
	public $util;
	
	/**
	 * @var \Budabot\Core\DB $db
	 * @Inject
	 */
	public $db;
	
	/**
	 * This handler is called on bot startup.
	 * @Setup
	 */
	public function setup() {
		$this->db->loadSQLFile($this->moduleName, 'trickle');
	}

	/**
	 * View trickle skills
	 *
	 * @HandlesCommand("trickle")
	 * @Matches("/^trickle( ([a-zA-Z]+) ([0-9]+)){1,6}$/i")
	 */
	public function trickle1Command($message, $channel, $sender, $sendto, $args) {
		$abilities = array('agi' => 0, 'int' => 0, 'psy' => 0, 'sta' => 0, 'str' => 0, 'sen' => 0);

		$array = explode(" ", $message);
		array_shift($array);
		for ($i = 0; isset($array[$i]); $i += 2) {
			$ability = $this->util->getAbility($array[$i]);
			if ($ability == null) {
				return false;
			}

			$abilities[$ability] += $array[1 + $i];
		}

		$msg = $this->processAbilities($abilities);
		$sendto->reply($msg);
	}
	
	/**
	 * View trickle skills
	 *
	 * @HandlesCommand("trickle")
	 * @Matches("/^trickle( ([0-9]+) ([a-zA-Z]+)){1,6}$/i")
	 */
	public function trickle2Command($message, $channel, $sender, $sendto, $args) {
		$abilities = array('agi' => 0, 'int' => 0, 'psy' => 0, 'sta' => 0, 'str' => 0, 'sen' => 0);

		$array = explode(" ", $message);
		array_shift($array);
		for ($i = 0; isset($array[$i]); $i += 2) {
			$ability = $this->util->getAbility($array[1 + $i]);
			if ($ability == null) {
				return false;
			}

			$abilities[$ability] += $array[$i];
		}

		$msg = $this->processAbilities($abilities);
		$sendto->reply($msg);
	}

	/**
	 * @HandlesCommand("trickle")
	 * @Matches("/^trickle (.+)$/i")
	 */
	public function trickleSkillCommand($message, $channel, $sender, $sendto, $args) {
		$search = $args[1];

		$data = $this->db->query("SELECT * FROM trickle WHERE name LIKE ?", "%" . str_replace(" ", "%", $search) . "%");
		$count = count($data);
		if ($count == 0) {
			$msg = "Could not find any skills for search '$search'";
		} elseif ($count == 1) {
			$row = $data[0];
			$msg = $this->getTrickleAmounts($row);
		} else {
			$blob = "";
			foreach ($data as $row) {
				$blob .= $this->getTrickleAmounts($row) . "\n";
			}
			$msg = $this->text->makeBlob("Trickle Info: $search", $blob);
		}

		$sendto->reply($msg);
	}

	public function getTrickleAmounts($row) {
		$arr = ['agi', 'int', 'psy', 'sta', 'str', 'sen'];
		$msg = "<highlight>$row->name<end> ";
		foreach ($arr as $ability) {
			$fieldName = "amount" . ucfirst($ability);
			if ($row->$fieldName > 0) {
				$abilityName = $this->util->getAbility($ability, true);
				$value = round(4 / ($row->$fieldName), 2);
				$msg .= "($abilityName: ${value}) ";
			}
		}
		return $msg;
	}
	
	private function processAbilities($abilities) {
		$that = $this;
		$abilitiesHeader = $this->util->mapFilterCombine($abilities, ", ", function($ability, $value) use ($that) {
			if ($value == 0) {
				return null;
			} else {
				return $that->util->getAbility($ability, true) . " <highlight>" . $value . "<end>";
			}
		});

		$results = $this->getTrickleResults($abilities);
		$blob = $this->formatOutput($results);
		$blob .= "\nBy Tyrence (RK2), inspired by the Bebot command of the same name";
		return $this->text->makeBlob("Trickle Results: $abilitiesHeader", $blob);
	}
	
	public function getTrickleResults($abilities) {
		$sql = "
			SELECT
				groupName,
				name,
				amountAgi,
				amountInt,
				amountPsy,
				amountSta,
				amountStr,
				amountSen,
				(amountAgi * {$abilities['agi']}
					+ amountInt * {$abilities['int']}
					+ amountPsy * {$abilities['psy']}
					+ amountSta * {$abilities['sta']}
					+ amountStr * {$abilities['str']}
					+ amountSen * {$abilities['sen']}) AS amount
			FROM
				trickle
			GROUP BY
				groupName,
				name,
				amountAgi,
				amountInt,
				amountPsy,
				amountSta,
				amountStr,
				amountSen
			HAVING
				amount > 0
			ORDER BY
				id";

		return $this->db->query($sql);
	}
	
	public function formatOutput($results) {
		$msg = "";
		$groupName = "";
		foreach ($results as $result) {
			if ($result->groupName != $groupName) {
				$groupName = $result->groupName;
				$msg .= "\n<header2>$groupName<end>\n";
			}

			$amount = $result->amount / 4;
			$msg .= "$result->name <highlight>$amount<end>";

			$msg .= "\n";
		}

		return $msg;
	}
}
