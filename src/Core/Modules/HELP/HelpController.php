<?php

namespace Budabot\Core\Modules\HELP;

/**
 * @author Tyrence (RK2)
 *
 * @Instance
 *
 * Commands this class contains:
 *	@DefineCommand(
 *		command       = 'help',
 *		accessLevel   = 'all',
 *		description   = 'Show help topics',
 *		help          = 'help.txt',
 *		defaultStatus = '1'
 *	)
 */
class HelpController {

	/**
	 * Name of the module.
	 * Set automatically by module loader.
	 */
	public $moduleName;

	/**
	 * @var \Budabot\Core\CommandManager $commandManager
	 * @Inject
	 */
	public $commandManager;
	
	/**
	 * @var \Budabot\Core\CommandAlias $commandAlias
	 * @Inject
	 */
	public $commandAlias;

	/**
	 * @var \Budabot\Core\HelpManager $helpManager
	 * @Inject
	 */
	public $helpManager;

	/**
	 * @var \Budabot\Core\Text $text
	 * @Inject
	 */
	public $text;

	/**
	 * @Setup
	 * This handler is called on bot startup.
	 */
	public function setup() {
		$this->helpManager->register($this->moduleName, "about", "about.txt", "all", "Info about the development of Budabot");
		
		$this->commandAlias->register($this->moduleName, "help about", "about");
	}
	
	public function getAbout() {
		global $version;
		$data = file_get_contents(__DIR__ . "/about.txt");
		$data = str_replace('<version>', $version, $data);
		return $this->text->makeBlob("About Budabot $version", $data);
	}
	
	/**
	 * @HandlesCommand("help")
	 * @Matches("/^help$/i")
	 */
	public function helpListCommand($message, $channel, $sender, $sendto) {
		global $version;

		$data = $this->helpManager->getAllHelpTopics($sender);

		if (count($data) == 0) {
			$msg = "No help files found.";
		} else {
			$blob = '';
			$current_module = '';
			foreach ($data as $row) {
				if ($current_module != $row->module) {
					$blob .= "\n<pagebreak><header2>{$row->module}:<end>\n";
					$current_module = $row->module;
				}
				$helpLink = $this->text->makeChatcmd($row->name, "/tell <myname> help $row->name");
				$blob .= "  {$helpLink}: {$row->description}\n";
			}

			$msg = $this->text->makeBlob("Help (main)", $blob);
		}

		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("help")
	 * @Matches("/^help (.+)$/i")
	 */
	public function helpShowCommand($message, $channel, $sender, $sendto, $args) {
		$helpcmd = strtolower($args[1]);
		
		if ($helpcmd == 'about') {
			$msg = $this->getAbout();
			$sendto->reply($msg);
			return;
		}
	
		// check for alias
		$row = $this->commandAlias->get($helpcmd);
		if ($row !== null && $row->status == 1) {
			$arr = explode(' ', $row->cmd);
			$helpcmd = $arr[0];
		}

		$blob = $this->helpManager->find($helpcmd, $sender);
		if ($blob !== false) {
			$helpcmd = ucfirst($helpcmd);
			$msg = $this->text->makeBlob("Help ($helpcmd)", $blob);
			$sendto->reply($msg);
		} else {
			$sendto->reply("No help found on this topic.");
		}
	}
}
