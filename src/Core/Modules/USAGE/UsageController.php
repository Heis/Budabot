<?php

namespace Budabot\Core\Modules\USAGE;

use Budabot\Core\Event;
use stdClass;
use Budabot\Core\CommandAlias;
use Budabot\Core\BotRunner;

/**
 * @author Tyrence (RK2)
 *
 * @Instance
 *
 * Commands this class contains:
 *	@DefineCommand(
 *		command       = 'usage',
 *		accessLevel   = 'guild',
 *		description   = 'Shows usage stats',
 *		help          = 'usage.txt',
 *		defaultStatus = '1'
 *	)
 */
class UsageController {
	/**
	 * Name of the module.
	 * Set automatically by module loader.
	 */
	public $moduleName;

	/**
	 * @var \Budabot\Core\DB $db
	 * @Inject
	 */
	public $db;

	/**
	 * @var \Budabot\Core\Http $http
	 * @Inject
	 */
	public $http;

	/**
	 * @var \Budabot\Core\SettingManager $settingManager
	 * @Inject
	 */
	public $settingManager;

	/**
	 * @var \Budabot\Core\EventManager $eventManager
	 * @Inject
	 */
	public $eventManager;

	/**
	 * @var \Budabot\Core\Util $util
	 * @Inject
	 */
	public $util;
	
	/**
	 * @var \Budabot\Core\Text $text
	 * @Inject
	 */
	public $text;

	/**
	 * @var \Budabot\Core\Budabot $chatBot
	 * @Inject
	 */
	public $chatBot;

	/**
	 * @Setup
	 */
	public function setup() {
		$this->db->loadSQLFile($this->moduleName, 'usage');
		
		$this->settingManager->add($this->moduleName, "record_usage_stats", "Record usage stats", "edit", "options", "1", "true;false", "1;0");
		$this->settingManager->add($this->moduleName, 'botid', 'Botid', 'noedit', 'text', '');
		$this->settingManager->add($this->moduleName, 'last_submitted_stats', 'last_submitted_stats', 'noedit', 'text', 0);
	}
	
	/**
	 * @HandlesCommand("usage")
	 * @Matches("/^usage player ([0-9a-z-]+)$/i")
	 * @Matches("/^usage player ([0-9a-z-]+) ([a-z0-9]+)$/i")
	 */
	public function usagePlayerCommand($message, $channel, $sender, $sendto, $args) {
		if (count($args) == 3) {
			$time = $this->util->parseTime($args[2]);
			if ($time == 0) {
				$msg = "Please enter a valid time.";
				$sendto->reply($msg);
				return;
			}
			$time = $time;
		} else {
			$time = 604800;
		}

		$timeString = $this->util->unixtimeToReadable($time);
		$time = time() - $time;
	
		$player = ucfirst(strtolower($args[1]));
	
		$sql = "SELECT command, COUNT(command) AS count FROM usage_<myname> WHERE sender = ? AND dt > ? GROUP BY command ORDER BY count DESC";
		$data = $this->db->query($sql, $player, $time);
		$count = count($data);

		if ($count > 0) {
			$blob = '';
			foreach ($data as $row) {
				$blob .= "<highlight>{$row->command}<end> ({$row->count})\n";
			}

			$msg = $this->text->makeBlob("Usage for $player - $timeString ($count)", $blob);
		} else {
			$msg = "No usage statistics found for <highlight>$player<end>.";
		}
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("usage")
	 * @Matches("/^usage cmd ([0-9a-z_-]+)$/i")
	 * @Matches("/^usage cmd ([0-9a-z_-]+) ([a-z0-9]+)$/i")
	 */
	public function usageCmdCommand($message, $channel, $sender, $sendto, $args) {
		if (count($args) == 3) {
			$time = $this->util->parseTime($args[2]);
			if ($time == 0) {
				$msg = "Please enter a valid time.";
				$sendto->reply($msg);
				return;
			}
			$time = $time;
		} else {
			$time = 604800;
		}

		$timeString = $this->util->unixtimeToReadable($time);
		$time = time() - $time;
	
		$cmd = strtolower($args[1]);
	
		$sql = "SELECT sender, COUNT(sender) AS count FROM usage_<myname> WHERE command = ? AND dt > ? GROUP BY sender ORDER BY count DESC";
		$data = $this->db->query($sql, $cmd, $time);
		$count = count($data);

		if ($count > 0) {
			$blob = '';
			foreach ($data as $row) {
				$blob .= "<highlight>{$row->sender}<end> ({$row->count})\n";
			}

			$msg = $this->text->makeBlob("Usage for $cmd - $timeString ($count)", $blob);
		} else {
			$msg = "No usage statistics found for <highlight>$cmd<end>.";
		}
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("usage")
	 * @Matches("/^usage$/i")
	 * @Matches("/^usage ([a-z0-9]+)$/i")
	 */
	public function usageCommand($message, $channel, $sender, $sendto, $args) {
		if (count($args) == 2) {
			$time = $this->util->parseTime($args[1]);
			if ($time == 0) {
				$msg = "Please enter a valid time.";
				$sendto->reply($msg);
				return;
			}
			$time = $time;
		} else {
			$time = 604800;
		}

		$timeString = $this->util->unixtimeToReadable($time);
		$time = time() - $time;
		$limit = 25;
		
		// channel usage
		$sql = "SELECT type, COUNT(type) cnt FROM usage_<myname> WHERE dt > ? GROUP BY type ORDER BY type";
		$data = $this->db->query($sql, $time);
		
		$blob = "<header2>Channel Usage<end>\n";
		foreach ($data as $row) {
			if ($row->type == "msg") {
				$blob .= "Number of commands executed in tells: <highlight>$row->cnt<end>\n";
			} elseif ($row->type == "priv") {
				$blob .= "Number of commands executed in private channel: <highlight>$row->cnt<end>\n";
			} elseif ($row->type == "guild") {
				$blob .= "Number of commands executed in guild channel: <highlight>$row->cnt<end>\n";
			}
		}
		$blob .= "\n";
		
		// most used commands
		$sql = "SELECT command, COUNT(command) AS count FROM usage_<myname> WHERE dt > ? GROUP BY command ORDER BY count DESC LIMIT ?";
		$data = $this->db->query($sql, $time, $limit);

		$blob .= "<header2>$limit Most Used Commands<end>\n";
		foreach ($data as $row) {
			$commandLink = $this->text->makeChatcmd($row->command, "/tell <myname> usage cmd $row->command");
			$blob .= "{$commandLink} ({$row->count})\n";
		}

		// users who have used the most commands
		$sql = "SELECT sender, COUNT(sender) AS count FROM usage_<myname> WHERE dt > ? GROUP BY sender ORDER BY count DESC LIMIT ?";
		$data = $this->db->query($sql, $time, $limit);

		$blob .= "\n<header2>$limit Most Active Users<end>\n";
		foreach ($data as $row) {
			$senderLink = $this->text->makeChatcmd($row->sender, "/tell <myname> usage player $row->sender");
			$blob .= "{$senderLink} ({$row->count})\n";
		}

		$msg = $this->text->makeBlob("Usage Statistics - $timeString", $blob);
		$sendto->reply($msg);
	}

	public function record($type, $cmd, $sender, $handler) {
		// don't record stats for !grc command or command aliases
		if ($cmd == 'grc' || "CommandAlias.process" == $handler) {
			return;
		}

		$sql = "INSERT INTO usage_<myname> (type, command, sender, dt) VALUES (?, ?, ?, ?)";
		$this->db->exec($sql, $type, $cmd, $sender, time());
	}

	/**
	 * @Event("timer(24hrs)")
	 * @Description("Submits anonymous usage stats to Budabot website")
	 * @DefaultStatus("0")
	 */
	public function submitAnonymousUsage(Event $eventObj) {
		$debug = false;
		$time = time();
		$settingName = 'last_submitted_stats';
		$lastSubmittedStats = $this->settingManager->get($settingName);

		$postArray['stats'] = json_encode($this->getUsageInfo($lastSubmittedStats, $time, $debug));

		$url = 'http://stats.budabot.jkbff.com/stats/submitUsage.php';
		$this->http->post($url)->withQueryParams($postArray);

		$this->settingManager->save($settingName, $time);
	}

	public function getUsageInfo($lastSubmittedStats, $now, $debug=false) {
		global $version;

		$botid = $this->settingManager->get('botid');
		if ($botid == '') {
			$botid = $this->util->genRandomString(20);
			$this->settingManager->save('botid', $botid);
		}

		$sql = "SELECT type, command FROM usage_<myname> WHERE dt >= ? AND dt < ?";
		$data = $this->db->query($sql, $lastSubmittedStats, $now);

		$settings = array();
		$settings['dimension'] = $this->chatBot->vars['dimension'];
		$settings['is_guild_bot'] = ($this->chatBot->vars['my_guild'] == '' ? '0' : '1');
		$settings['guildsize'] = $this->getGuildSizeClass(count($this->chatBot->guildmembers));
		$settings['using_chat_proxy'] = $this->chatBot->vars['use_proxy'];
		$settings['db_type'] = $this->db->getType();
		$settings['bot_version'] = $version;
		$settings['using_git'] = (int)file_exists(dirname(__DIR__) . "/GIT_MODULE/GitController.class.php");
		$settings['os'] = (BotRunner::isWindows() === true ? 'Windows' : 'Other');
		
		$settings['symbol'] = $this->settingManager->get('symbol');
		$settings['relay_enabled'] = ($this->settingManager->get('relaybot') == 'Off' ? '0' : '1');
		$settings['relay_type'] = $this->settingManager->get('relaytype');
		$settings['first_and_last_alt_only'] = $this->settingManager->get('first_and_last_alt_only');
		$settings['aodb_db_version'] = $this->settingManager->get('aodb_db_version');
		$settings['max_blob_size'] = $this->settingManager->get('max_blob_size');
		$settings['online_show_org_guild'] = $this->settingManager->get('online_show_org_guild');
		$settings['online_show_org_priv'] = $this->settingManager->get('online_show_org_priv');
		$settings['online_admin'] = $this->settingManager->get('online_admin');
		$settings['relay_symbol_method'] = $this->settingManager->get('relay_symbol_method');
		$settings['http_server_enable'] = ($this->eventManager->getKeyForCronEvent("60", "httpservercontroller.startHTTPServer") != null ? "1" : "0");
		$settings['tower_attack_spam'] = $this->settingManager->get('tower_attack_spam');

		$obj = new stdClass;
		$obj->id = sha1($botid . $this->chatBot->vars['name'] . $this->chatBot->vars['dimension']);
		$obj->version = "2";
		$obj->debug = ($debug == true ? '1' : '0');
		$obj->commands = $data;
		$obj->settings = $settings;

		return $obj;
	}

	public function getGuildSizeClass($size) {
		$guildClass = "";
		if ($size == 0) {
			$guildClass = "class0";
		} elseif ($size < 10) {
			$guildClass = "class1";
		} elseif ($size < 30) {
			$guildClass = "class2";
		} elseif ($size < 150) {
			$guildClass = "class3";
		} elseif ($size < 300) {
			$guildClass = "class4";
		} elseif ($size < 650) {
			$guildClass = "class5";
		} elseif ($size < 1000) {
			$guildClass = "class6";
		} else {
			$guildClass = "class7";
		}
		return $guildClass;
	}
}
