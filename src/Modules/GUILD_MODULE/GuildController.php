<?php

namespace Budabot\Modules\GUILD_MODULE;

use Budabot\Core\Event;

/**
 * Authors:
 *  - Tyrence (RK2)
 *  - Mindrila (RK1)
 *  - Derroylo (RK2)
 *
 * @Instance
 *
 * Commands this controller contains:
 *	@DefineCommand(
 *		command     = "logon",
 *		accessLevel = "guild",
 *		description = "Set logon message",
 *		help        = "logon_msg.txt"
 *	)
 *	@DefineCommand(
 *		command     = "logoff",
 *		accessLevel = "guild",
 *		description = "Set logoff message",
 *		help        = "logoff_msg.txt"
 *	)
 *	@DefineCommand(
 *		command     = "lastseen",
 *		accessLevel = "guild",
 *		description = "Shows the last logoff time of a character",
 *		help        = "lastseen.txt"
 *	)
 *	@DefineCommand(
 *		command     = "recentseen",
 *		accessLevel = "guild",
 *		description = "Shows org members who have logged off recently",
 *		help        = "recentseen.txt"
 *	)
 *	@DefineCommand(
 *		command     = "notify",
 *		accessLevel = "mod",
 *		description = "Adds a character to the notify list manually",
 *		help        = "notify.txt"
 *	)
 *	@DefineCommand(
 *		command     = "updateorg",
 *		accessLevel = "mod",
 *		description = "Force an update of the org roster",
 *		help        = "updateorg.txt"
 *	)
 */
class GuildController {

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
	 * @var \Budabot\Core\Budabot $chatBot
	 * @Inject
	 */
	public $chatBot;
	
	/**
	 * @var \Budabot\Core\SettingManager $settingManager
	 * @Inject
	 */
	public $settingManager;
	
	/**
	 * @var \Budabot\Core\BuddylistManager $buddylistManager
	 * @Inject
	 */
	public $buddylistManager;
	
	/**
	 * @var \Budabot\Core\Modules\PLAYER_LOOKUP\PlayerManager $playerManager
	 * @Inject
	 */
	public $playerManager;
	
	/**
	 * @var \Budabot\Core\Modules\PLAYER_LOOKUP\GuildManager $guildManager
	 * @Inject
	 */
	public $guildManager;
	
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
	 * @var \Budabot\Core\Modules\ALTS\AltsController $altsController
	 * @Inject
	 */
	public $altsController;
	
	/**
	 * @var \Budabot\Core\Modules\PREFERENCES\Preferences $preferences
	 * @Inject
	 */
	public $preferences;
	
	/**
	 * @var \Budabot\Core\LoggerWrapper $logger
	 * @Logger
	 */
	public $logger;
	
	/**
	 * @Setup
	 */
	public function setup() {
		$this->db->loadSQLFile($this->moduleName, "org_members");
		
		$this->settingManager->add($this->moduleName, "max_logon_msg_size", "Maximum characters a logon message can have", "edit", "number", "200", "100;200;300;400", '', "mod");
		$this->settingManager->add($this->moduleName, "max_logoff_msg_size", "Maximum characters a logoff message can have", "edit", "number", "200", "100;200;300;400", '', "mod");
		$this->settingManager->add($this->moduleName, "first_and_last_alt_only", "Show logon/logoff for first/last alt only", "edit", "options", "0", "true;false", "1;0");
		
		$this->chatBot->guildmembers = array();
		$sql = "SELECT o.name, IFNULL(p.guild_rank_id, 6) AS guild_rank_id 
			FROM org_members_<myname> o LEFT JOIN players p ON (o.name = p.name AND p.dimension = '<dim>' AND p.guild = '<myguild>')
			WHERE mode != 'del'";
		$data = $this->db->query($sql);
		foreach ($data as $row) {
			$this->chatBot->guildmembers[$row->name] = $row->guild_rank_id;
		}
	}

	/**
	 * @HandlesCommand("logon")
	 * @Matches("/^logon$/i")
	 */
	public function logonMessageShowCommand($message, $channel, $sender, $sendto, $args) {
		$logon_msg = $this->preferences->get($sender, 'logon_msg');

		if ($logon_msg === false || $logon_msg == '') {
			$msg = "Your logon message has not been set.";
		} else {
			$msg = "{$sender} logon: {$logon_msg}";
		}
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("logon")
	 * @Matches("/^logon (.+)$/i")
	 */
	public function logonMessageSetCommand($message, $channel, $sender, $sendto, $args) {
		$logon_msg = $args[1];

		if ($logon_msg == 'clear') {
			$this->preferences->save($sender, 'logon_msg', '');
			$msg = "Your logon message has been cleared.";
		} elseif (strlen($logon_msg) <= $this->settingManager->get('max_logon_msg_size')) {
			$this->preferences->save($sender, 'logon_msg', $logon_msg);
			$msg = "Your logon message has been set.";
		} else {
			$msg = "Your logon message is too large. Your logon message may contain a maximum of " . $this->settingManager->get('max_logon_msg_size') . " characters.";
		}
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("logoff")
	 * @Matches("/^logoff$/i")
	 */
	public function logoffMessageShowCommand($message, $channel, $sender, $sendto, $args) {
		$logoff_msg = $this->preferences->get($sender, 'logoff_msg');

		if ($logoff_msg === false || $logoff_msg == '') {
			$msg = "Your logoff message has not been set.";
		} else {
			$msg = "{$sender} logoff: {$logoff_msg}";
		}
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("logoff")
	 * @Matches("/^logoff (.+)$/i")
	 */
	public function logoffMessageSetCommand($message, $channel, $sender, $sendto, $args) {
		$logoff_msg = $args[1];

		if ($logoff_msg == 'clear') {
			$this->preferences->save($sender, 'logoff_msg', '');
			$msg = "Your logoff message has been cleared.";
		} elseif (strlen($logoff_msg) <= $this->settingManager->get('max_logoff_msg_size')) {
			$this->preferences->save($sender, 'logoff_msg', $logoff_msg);
			$msg = "Your logoff message has been set.";
		} else {
			$msg = "Your logoff message is too large. Your logoff message may contain a maximum of " . $this->settingManager->get('max_logoff_msg_size') . " characters.";
		}
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("lastseen")
	 * @Matches("/^lastseen (.+)$/i")
	 */
	public function lastseenCommand($message, $channel, $sender, $sendto, $args) {
		$name = ucfirst(strtolower($args[1]));
		$uid = $this->chatBot->get_uid($name);
		if (!$uid) {
			$msg = "Character <highlight>$name<end> does not exist.";
			$sendto->reply($msg);
			return;
		}
		$altInfo = $this->altsController->getAltInfo($name);
		$onlineAlts = $altInfo->getOnlineAlts();

		$blob = "";
		foreach ($onlineAlts as $onlineAlt) {
			$blob .= "<highlight>$onlineAlt<end> is currently online.\n";
		}
		
		$namesSql = implode(",", array_map(function($alt) {
			return "'$alt'";
		}, $altInfo->getAllAlts()));
		$data = $this->db->query("SELECT * FROM org_members_<myname> WHERE `name` IN ($namesSql) AND `mode` != 'del' ORDER BY logged_off DESC");

		foreach ($data as $row) {
			if (in_array($row->name, $onlineAlts)) {
				// skip
				continue;
			} elseif ($row->logged_off == 0) {
				$blob .= "<highlight>$row->name<end> has never logged on.\n";
			} else {
				$blob .= "<highlight>$row->name<end> last seen at " . $this->util->date($row->logged_off) . ".\n";
			}
		}

		$msg = "Character <highlight>$name<end> is not a member of the org.";
		if (count($data) !== 0) {
			$msg = $this->text->makeBlob("Last Seen Info for $altInfo->main", $blob);
		}

		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("recentseen")
	 * @Matches("/^recentseen ([a-z0-9]+)/i")
	 */
	public function recentseenCommand($message, $channel, $sender, $sendto, $args) {
		if (!$this->isGuildBot()) {
			$sendto->reply("The bot must be in an org.");
			return;
		}

		$time = $this->util->parseTime($args[1]);
		if ($time < 1) {
			$msg = "You must enter a valid time parameter.";
			$sendto->reply($msg);
			return;
		}

		$timeString = $this->util->unixtimeToReadable($time, false);
		$time = time() - $time;

		$data = $this->db->query(
			"SELECT CASE WHEN a.main IS NULL THEN o.name ELSE a.main END AS main, o.logged_off, o.name ".
			"FROM org_members_<myname> o ".
			"LEFT JOIN alts a ON o.name = a.alt ".
			"WHERE `mode` != 'del' AND `logged_off` > ? ".
			"ORDER BY 1, o.logged_off desc, o.name",
			$time
		);

		if (count($data) == 0) {
			$sendto->reply("No members recorded.");
			return;
		}

		$numrecentcount = 0;
		$highlight = 0;

		$blob = "Org members who have logged off within the last <highlight>{$timeString}<end>.\n\n";
		
		$prevtoon = '';
		foreach ($data as $row) {
			if ($row->main != $prevtoon) {
				$prevtoon = $row->main;
				$numrecentcount++;
				$alts = $this->text->makeChatcmd("Alts", "/tell <myname> alts {$row->main}");
				$logged = $row->logged_off;
				$lasttoon = $row->name;

				$character = "<pagebreak>" . $row->main . " [{$alts}]\nLast seen as [$lasttoon] on " . $this->util->date($logged) . "\n\n";
				if ($highlight == 1) {
					$blob .= "<highlight>$character<end>";
					$highlight = 0;
				} else {
					$blob .= $character;
					$highlight = 1;
				}
			}
		}
		$msg = $this->text->makeBlob("$numrecentcount recently seen org members", $blob);
		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("notify")
	 * @Matches("/^notify (on|add) (.+)$/i")
	 */
	public function notifyAddCommand($message, $channel, $sender, $sendto, $args) {
		$name = ucfirst(strtolower($args[2]));
		$uid = $this->chatBot->get_uid($name);

		if (!$uid) {
			$msg = "<highlight>{$name}<end> does not exist.";
			$sendto->reply($msg);
			return;
		}

		$row = $this->db->queryRow("SELECT mode FROM org_members_<myname> WHERE `name` = ?", $name);

		if ($row !== null && $row->mode != "del") {
			$msg = "<highlight>{$name}<end> is already on the Notify list.";
		} else {
			if ($row === null) {
				$this->db->exec("INSERT INTO org_members_<myname> (`name`, `mode`) VALUES (?, 'add')", $name);
			} else {
				$this->db->exec("UPDATE org_members_<myname> SET `mode` = 'add' WHERE `name` = ?", $name);
			}

			if ($this->buddylistManager->isOnline($name) == 1) {
				$this->db->exec("INSERT INTO online (`name`, `channel`, `channel_type`, `added_by`, `dt`) VALUES (?, '<myguild>', 'guild', '<myname>', ?)", $name, time());
			}
			$this->buddylistManager->add($name, 'org');
			$this->chatBot->guildmembers[$name] = 6;
			$msg = "<highlight>{$name}<end> has been added to the Notify list.";
		}

		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("notify")
	 * @Matches("/^notify (off|rem) (.+)$/i")
	 */
	public function notifyRemoveCommand($message, $channel, $sender, $sendto, $args) {
		$name = ucfirst(strtolower($args[2]));
		$uid = $this->chatBot->get_uid($name);

		if (!$uid) {
			$msg = "<highlight>{$name}<end> does not exist.";
			$sendto->reply($msg);
			return;
		}

		$row = $this->db->queryRow("SELECT mode FROM org_members_<myname> WHERE `name` = ?", $name);

		if ($row === null) {
			$msg = "<highlight>{$name}<end> is not on the guild roster.";
		} elseif ($row->mode == "del") {
			$msg = "<highlight>{$name}<end> has already been removed from the Notify list.";
		} else {
			$this->db->exec("UPDATE org_members_<myname> SET `mode` = 'del' WHERE `name` = ?", $name);
			$this->db->exec("DELETE FROM online WHERE `name` = ? AND `channel_type` = 'guild' AND added_by = '<myname>'", $name);
			$this->buddylistManager->remove($name, 'org');
			unset($this->chatBot->guildmembers[$name]);
			$msg = "Removed <highlight>{$name}<end> from the Notify list.";
		}

		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("updateorg")
	 * @Matches("/^updateorg$/i")
	 */
	public function updateorgCommand($message, $channel, $sender, $sendto, $args) {
		$force_update = true;
		$sendto->reply("Starting Roster update");
		$this->updateOrgRoster();
		$sendto->reply("Finished Roster update");
	}
	
	public function updateOrgRoster() {
		if ($this->isGuildBot()) {
			$this->logger->log('INFO', "Starting Roster update");

			// Get the guild info
			$org = $this->guildManager->getById($this->chatBot->vars["my_guild_id"], $this->chatBot->vars["dimension"], true);

			// Check if guild xml file is correct if not abort
			if ($org === null) {
				$this->logger->log('ERROR', "Error downloading the guild roster xml file");
				return;
			}

			if (count($org->members) == 0) {
				$this->logger->log('ERROR', "Guild xml file has no members! Aborting roster update.");
				return;
			}

			// Save the current org_members table in a var
			$data = $this->db->query("SELECT * FROM org_members_<myname>");
			if (count($data) == 0 && (count($org->members) > 0)) {
				$restart = true;
			} else {
				$restart = false;
				foreach ($data as $row) {
					$dbentrys[$row->name]["name"] = $row->name;
					$dbentrys[$row->name]["mode"] = $row->mode;
				}
			}

			$this->chatBot->ready = false;

			$this->db->beginTransaction();

			// Going through each member of the org and add or update his/her
			foreach ($org->members as $member) {
				// don't do anything if $member is the bot itself
				if (strtolower($member->name) == strtolower($this->chatBot->vars["name"])) {
					continue;
				}

				//If there exists already data about the character just update him/her
				if (isset($dbentrys[$member->name])) {
					if ($dbentrys[$member->name]["mode"] == "del") {
						// members who are not on notify should not be on the buddy list but should remain in the database
						$this->buddylistManager->remove($member->name, 'org');
						unset($this->chatBot->guildmembers[$member->name]);
					} else {
						// add org members who are on notify to buddy list
						$this->buddylistManager->add($member->name, 'org');
						$this->chatBot->guildmembers[$member->name] = $member->guild_rank_id;

						// if member was added to notify list manually, switch mode to org and let guild roster update from now on
						if ($dbentrys[$member->name]["mode"] == "add") {
							$this->db->exec("UPDATE org_members_<myname> SET `mode` = 'org' WHERE `name` = ?", $member->name);
						}
					}
				//Else insert his/her data
				} else {
					// add new org members to buddy list
					$this->buddylistManager->add($member->name, 'org');
					$this->chatBot->guildmembers[$member->name] = $member->guild_rank_id;

					$this->db->exec("INSERT INTO org_members_<myname> (`name`, `mode`) VALUES (?, 'org')", $member->name);
				}
				unset($dbentrys[$member->name]);
			}

			$this->db->commit();

			// remove buddies who are no longer org members
			foreach ($dbentrys as $buddy) {
				if ($buddy['mode'] != 'add') {
					$this->db->exec("DELETE FROM online WHERE `name` = ? AND `channel_type` = 'guild' AND added_by = '<myname>'", $buddy['name']);
					$this->db->exec("DELETE FROM org_members_<myname> WHERE `name` = ?", $buddy['name']);
					$this->buddylistManager->remove($buddy['name'], 'org');
					unset($this->chatBot->guildmembers[$buddy['name']]);
				}
			}

			$this->logger->log('INFO', "Finished Roster update");

			if ($restart == true) {
				$this->chatBot->sendGuild("Guild roster has been loaded for the first time. Restarting...");

				$this->logger->log('INFO', "The bot is restarting");

				sleep(5);

				// in case some of the org members were already on the buddy list, we need to restart the bot
				// in order to get them to appear on the online list
				die();
			}
		}
	}

	/**
	 * @Event("timer(24hrs)")
	 * @Description("Download guild roster xml and update guild members")
	 */
	public function downloadOrgRosterEvent(Event $eventObj) {
		$this->updateOrgRoster();
	}
	
	/**
	 * @Event("orgmsg")
	 * @Description("Automatically update guild roster as characters join and leave the guild")
	 */
	public function autoNotifyOrgMembersEvent(Event $eventObj) {
		$message = $eventObj->message;
		if (preg_match("/^(.+) invited (.+) to your organization.$/", $message, $arr)) {
			$name = ucfirst(strtolower($arr[2]));

			if ($this->buddylistManager->isOnline("") == 1) {
				$this->db->exec("INSERT INTO online (`name`, `channel`,  `channel_type`, `added_by`, `dt`) VALUES (?, '<myguild>', 'guild', '<myname>', ?)", $name, time());
			}

			$row = $this->db->queryRow("SELECT * FROM org_members_<myname> WHERE `name` = ?", $name);
			if ($row !== null) {
				$this->db->exec("UPDATE org_members_<myname> SET `mode` = 'add' WHERE `name` = ?", $name);
				$this->buddylistManager->add($name, 'org');
				$this->chatBot->guildmembers[$name] = 6;
			} else {
				$this->db->exec("INSERT INTO org_members_<myname> (`mode`, `name`) VALUES ('add', ?)", $name);
				$this->buddylistManager->add($name, 'org');
				$this->chatBot->guildmembers[$name] = 6;
			}

			// update character info
			$this->playerManager->getByName($name);
		} elseif (preg_match("/^(.+) kicked (.+) from your organization.$/", $message, $arr) || preg_match("/^(.+) removed inactive character (.+) from your organization.$/", $message, $arr)) {
			$name = ucfirst(strtolower($arr[2]));

			$this->db->exec("UPDATE org_members_<myname> SET `mode` = 'del' WHERE `name` = ?", $name);
			$this->db->exec("DELETE FROM online WHERE `name` = ? AND `channel_type` = 'guild' AND added_by = '<myname>'", $name);

			unset($this->chatBot->guildmembers[$name]);
			$this->buddylistManager->remove($name, 'org');
		} elseif (preg_match("/^(.+) just left your organization.$/", $message, $arr) || preg_match("/^(.+) kicked from organization \\(alignment changed\\).$/", $message, $arr)) {
			$name = ucfirst(strtolower($arr[1]));

			$this->db->exec("UPDATE org_members_<myname> SET `mode` = 'del' WHERE `name` = ?", $name);
			$this->db->exec("DELETE FROM online WHERE `name` = ? AND `channel_type` = 'guild' AND added_by = '<myname>'", $name);

			unset($this->chatBot->guildmembers[$name]);
			$this->buddylistManager->remove($name, 'org');
		}
	}
	
	/**
	 * @Event("logOn")
	 * @Description("Shows an org member logon in chat")
	 */
	public function orgMemberLogonMessageEvent(Event $eventObj) {
		$sender = $eventObj->sender;
		if (isset($this->chatBot->guildmembers[$sender]) && $this->chatBot->isReady()) {
			if ($this->settingManager->get('first_and_last_alt_only') == 1) {
				// if at least one alt/main is still online, don't show logoff message
				$altInfo = $this->altsController->getAltInfo($sender);
				if (count($altInfo->getOnlineAlts()) > 1) {
					return;
				}
			}

			$whois = $this->playerManager->getByName($sender);

			$msg = '';
			if ($whois === null) {
				$msg = "$sender logged on.";
			} else {
				$msg = $this->playerManager->getInfo($whois);

				$msg .= " logged on.";

				$altInfo = $this->altsController->getAltInfo($sender);
				if (count($altInfo->alts) > 0) {
					$msg .= " " . $altInfo->getAltsBlob(false, true);
				}
			}

			$logon_msg = $this->preferences->get($sender, 'logon_msg');
			if ($logon_msg !== false && $logon_msg != '') {
				$msg .= " - " . $logon_msg;
			}

			$this->chatBot->sendGuild($msg, true);

			//private channel part
			if ($this->settingManager->get("guest_relay") == 1) {
				$this->chatBot->sendPrivate($msg, true);
			}
		}
	}
	
	/**
	 * @Event("logOff")
	 * @Description("Shows an org member logoff in chat")
	 */
	public function orgMemberLogoffMessageEvent(Event $eventObj) {
		$sender = $eventObj->sender;
		if (isset($this->chatBot->guildmembers[$sender]) && $this->chatBot->isReady()) {
			if ($this->settingManager->get('first_and_last_alt_only') == 1) {
				// if at least one alt/main is already online, don't show logoff message
				$altInfo = $this->altsController->getAltInfo($sender);
				if (count($altInfo->getOnlineAlts()) > 0) {
					return;
				}
			}

			$msg = "$sender logged off.";
			$logoff_msg = $this->preferences->get($sender, 'logoff_msg');
			if ($logoff_msg !== false && $logoff_msg != '') {
				$msg .= " - " . $logoff_msg;
			}

			$this->chatBot->sendGuild($msg, true);

			//private channel part
			if ($this->settingManager->get("guest_relay") == 1) {
				$this->chatBot->sendPrivate($msg, true);
			}
		}
	}
	
	/**
	 * @Event("logOff")
	 * @Description("Record org member logoff for lastseen command")
	 */
	public function orgMemberLogoffRecordEvent(Event $eventObj) {
		$sender = $eventObj->sender;
		if (isset($this->chatBot->guildmembers[$sender]) && $this->chatBot->isReady()) {
			$this->db->exec("UPDATE org_members_<myname> SET `logged_off` = ? WHERE `name` = ?", time(), $sender);
		}
	}
	
	public function isGuildBot() {
		return !empty($this->chatBot->vars["my_guild"]) && !empty($this->chatBot->vars["my_guild_id"]);
	}
	
	/**
	 * @Event("connect")
	 * @Description("Verifies that org name is correct")
	 */
	public function verifyOrgNameEvent(Event $eventObj) {
		if (!empty($this->chatBot->vars["my_guild"])) {
			if (empty($this->chatBot->vars["my_guild_id"])) {
				$this->logger->log('warn', "Org name '{$this->chatBot->vars["my_guild"]}' specified, but bot does not appear to belong to an org");
			} else {
				$gid = $this->getOrgChannelIdByOrgId($this->chatBot->vars["my_guild_id"]);
				$orgChannel = $this->chatBot->gid[$gid];
				if ($orgChannel != "Clan (name unknown)" && $orgChannel != $this->chatBot->vars["my_guild"]) {
					$this->logger->log('warn', "Org name '{$this->chatBot->vars["my_guild"]}' specified, but bot belongs to org '$orgChannel'");
				}
			}
		}
	}
	
	public function getOrgChannelIdByOrgId($orgId) {
		foreach ($this->chatBot->grp as $gid => $status) {
			$string = unpack("N", substr($gid, 1));
			if (ord(substr($gid, 0, 1)) == 3 && $string[1] == $orgId) {
				return $gid;
			}
		}
		return null;
	}
}