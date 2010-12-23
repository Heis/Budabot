<?php
   /*
   ** Author: Sebuda (RK2)
   ** Description: General Help/Shows all helpfiles
   ** Version: 0.3
   **
   ** Developed for: Budabot(http://sourceforge.net/projects/budabot)
   **
   ** Date(created): 01.10.2005
   ** Date(last modified): 21.11.2006
   **
   ** Copyright (C) 2005, 2006 J. Gracik
   **
   ** Licence Infos:
   ** This file is part of Budabot.
   **
   ** Budabot is free software; you can redistribute it and/or modify
   ** it under the terms of the GNU General Public License as published by
   ** the Free Software Foundation; either version 2 of the License, or
   ** (at your option) any later version.
   **
   ** Budabot is distributed in the hope that it will be useful,
   ** but WITHOUT ANY WARRANTY; without even the implied warranty of
   ** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   ** GNU General Public License for more details.
   **
   ** You should have received a copy of the GNU General Public License
   ** along with Budabot; if not, write to the Free Software
   ** Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
   */

if (preg_match("/^about$/i", $message) || preg_match("/^help about$/i", $message)) {
	global $version;
	$data = file_get_contents("./core/HELP/about.txt");
	$data = str_replace('<version>', $version, $data);
	$msg = bot::makeLink("About", $data);
	bot::send($msg, $sendto);
} else if (preg_match("/^help$/i", $message)) {
	global $version;
	$data = "\nBudabot version: $version\n\n";
	ksort($this->helpfiles);
	forEach ($this->helpfiles as $cat => $value) {
		forEach ($value as $key => $file) {
		  	$access = false;
			$admin = $file["admin level"];

			if ($file["status"] == "enabled") {
				$num = 1;
			} else {
				$module = $file["module"];
				$db->query("SELECT * FROM cmdcfg_<myname> WHERE `module` = '$module' AND `status` = 1");
				$num = $db->numrows();
			}

			if ($admin == "guild" && isset($this->guildmembers[$sender]) && $type == "msg") {
			  	$access = true;
			} else if ($admin == "guildadmin" && ($this->guildmembers[$sender] <= $this->settings['guild_admin_level']) && $type == "msg") {
				$access = true;
			} else if (is_numeric($admin) && ($this->admins[$sender]["level"] >= $admin) && $type == "msg") {
				$access = true;
			} else if (($admin == "all" || $admin == "") && $type == "msg") {
				$access = true;
			} else if ($admin == "all" || $admin == "") {
				$access = true;
			} else if ($admin == "guild" && $type == "guild") {
				$access = true;
			}
				
			if (($access == true && $file["info"] != "" && $num > 0) || ($this->admins[$sender]["level"] == 4 && $file["info"] != "" && $type == "msg")) {
				$list .= "  *{$file["info"]} <a href='chatcmd:///tell <myname> help $key'>Click here</a>\n";
			} else if (($access == true && $num > 0) || ($this->admins[$sender]["level"] == 4 && $type == "msg")) {
				$list .= "  *Basic Help. <a href='chatcmd:///tell <myname> help $key'>Click here</a>\n";
			}
		}
		if ($list != "") {
		  	$msg .= "<highlight><u>$cat:</u><end>\n$list\n";
		  	$list = "";
		}
		
	}
	if ($msg == "") {
		$msg = "<red>No Helpfiles found.<end>";
	}

	$link = bot::makeLink("Help(main)", $data.$msg);

	bot::send($link, $sendto);
} else if (preg_match("/^help (.+)$/i", $message, $arr)) {
	if (($output = bot::help_lookup($arr[1], $sender)) !== FALSE) {
		bot::send($output, $sendto);
	} else {
		bot::send("No help found on this topic.", $sendto);
	}
}

?>