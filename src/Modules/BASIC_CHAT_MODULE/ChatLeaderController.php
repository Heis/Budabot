<?php

namespace Budabot\Modules\BASIC_CHAT_MODULE;

use Budabot\Core\Event;

/**
 * @Instance
 *
 * Commands this controller contains:
 *	@DefineCommand(
 *		command     = 'leader',
 *		accessLevel = 'all',
 *		description = 'Sets the Leader of the raid',
 *		help        = 'leader.txt'
 *	)
 *	@DefineCommand(
 *		command     = 'leader (.+)',
 *		accessLevel = 'rl',
 *		description = 'Sets a specific Leader',
 *		help        = 'leader.txt'
 *	)
 *	@DefineCommand(
 *		command     = 'leaderecho',
 *		accessLevel = 'rl',
 *		description = 'Set if the text of the leader will be repeated',
 *		help        = 'leader.txt'
 *	)
 */

class ChatLeaderController {
	
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
	 * @var \Budabot\Core\AccessManager $accessManager
	 * @Inject
	 */
	public $accessManager;

	/**
	 * @Setting("leaderecho")
	 * @Description("Repeat the text of the leader")
	 * @Visibility("edit")
	 * @Type("options")
	 * @Options("true;false")
	 * @Intoptions("1;0")
	 */
	public $defaultLeaderecho = '1';

	/**
	 * @Setting("leaderecho_color")
	 * @Description("Color for leader echo")
	 * @Visibility("edit")
	 * @Type("color")
	 */
	public $defaultLeaderechoColor = '<font color=#FFFF00>';

	/**
	 * Name of the leader character.
	 */
	private $leader;

	/**
	 * This command handler sets the leader of the raid.
	 * @HandlesCommand("leader")
	 * @Matches("/^leader$/i")
	 */
	public function leaderCommand($message, $channel, $sender, $sendto, $args) {
		if ($this->leader == $sender) {
			unset($this->leader);
			$this->chatBot->sendPrivate("Raid Leader cleared.");
			return;
		}
		$msg = $this->setLeader($sender, $sender);
		if (!empty($msg)) {
			$sendto->reply($msg);
		}
	}

	/**
	 * This command handler sets a specific leader.
	 * @HandlesCommand("leader (.+)")
	 * @Matches("/^leader (.+)$/i")
	 */
	public function leaderSetCommand($message, $channel, $sender, $sendto, $args) {
		$msg = $this->setLeader($args[1], $sender);
		if (!empty($msg)) {
			$sendto->reply($msg);
		}
	}
	
	public function setLeader($name, $sender) {
		$name = ucfirst(strtolower($name));
		$uid = $this->chatBot->get_uid($name);
		if (!$uid) {
			$msg = "Character <highlight>{$name}<end> does not exist.";
		} elseif (!isset($this->chatBot->chatlist[$name])) {
			$msg = "Character <highlight>{$name}<end> is not in the private channel.";
		} else {
			if (!isset($this->leader) || $sender == $this->leader || $this->accessManager->compareCharacterAccessLevels($sender, $this->leader) > 0) {
				$this->leader = $name;
				$this->chatBot->sendPrivate($this->getLeaderStatusText());
			} else {
				$msg = "You cannot take Raid Leader from <highlight>{$this->leader}<end>.";
			}
		}
		return $msg;
	}

	/**
	 * This command handler enables leader echoing in private channel.
	 * @HandlesCommand("leaderecho")
	 * @Matches("/^leaderecho on$/i")
	 */
	public function leaderechoOnCommand($message, $channel, $sender, $sendto, $args) {
		if ($this->checkLeaderAccess($sender)) {
			$this->settingManager->save("leaderecho", "1");
			$this->chatBot->sendPrivate("Leader echo has been " . $this->getEchoStatusText());
		} else {
			$sendto->reply("You must be Raid Leader to use this command.");
		}
	}

	/**
	 * This command handler disables leader echoing in private channel.
	 * @HandlesCommand("leaderecho")
	 * @Matches("/^leaderecho off$/i")
	 */
	public function leaderechoOffCommand($message, $channel, $sender, $sendto, $args) {
		if ($this->checkLeaderAccess($sender)) {
			$this->settingManager->save("leaderecho", "0");
			$this->chatBot->sendPrivate("Leader echo has been " . $this->getEchoStatusText());
		} else {
			$sendto->reply("You must be Raid Leader to use this command.");
		}
	}

	/**
	 * This command handler shows current echoing state.
	 * @HandlesCommand("leaderecho")
	 * @Matches("/^leaderecho$/i")
	 */
	public function leaderechoCommand($message, $channel, $sender, $sendto, $args) {
		if ($this->checkLeaderAccess($sender)) {
			$this->chatBot->sendPrivate("Leader echo is currently " . $this->getEchoStatusText());
		} else {
			$sendto->reply("You must be Raid Leader to use this command.");
		}
	}

	/**
	 * @Event("priv")
	 * @Description("Repeats what the leader says in the color of leaderecho_color setting")
	 */
	public function privEvent(Event $eventObj) {
		if ($this->settingManager->get("leaderecho") == 1 && $this->leader == $eventObj->sender && $eventObj->message[0] != $this->settingManager->get("symbol")) {
			$msg = $this->settingManager->get("leaderecho_color") . $eventObj->message . "<end>";
			$this->chatBot->sendPrivate($msg);
		}
	}

	/**
	 * @Event("leavePriv")
	 * @Description("Removes leader when the leader leaves the channel")
	 */
	public function leavePrivEvent(Event $eventObj) {
		if ($this->leader == $eventObj->sender) {
			unset($this->leader);
			$msg = "Raid Leader cleared.";
			$this->chatBot->sendPrivate($msg);
		}
	}

	/**
	 * Returns echo's status message based on 'leaderecho' setting.
	 */
	private function getEchoStatusText() {
		if ($this->settingManager->get("leaderecho") == 1) {
			$status = "<green>Enabled<end>";
		} else {
			$status = "<red>Disabled<end>";
		}
		return $status;
	}

	/**
	 * Returns current leader and echo's current status.
	 */
	private function getLeaderStatusText() {
		$cmd = $this->settingManager->get("leaderecho") == 1? "off": "on";
		$status = $this->getEchoStatusText();
		$msg = "{$this->leader} is now Raid Leader. Leader echo is currently {$status}. You can change it with <symbol>leaderecho {$cmd}";
		return $msg;
	}
	
	public function getLeader() {
		return $this->leader;
	}

	public function checkLeaderAccess($sender) {
		if (empty($this->leader)) {
			return true;
		} elseif ($this->leader == $sender) {
			return true;
		} elseif ($this->accessManager->checkAccess($sender, "moderator")) {
			return true;
		}
		return false;
	}
}
