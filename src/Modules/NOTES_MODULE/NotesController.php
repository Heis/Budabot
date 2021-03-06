<?php

namespace Budabot\Modules\NOTES_MODULE;

/**
 * @author Tyrence (RK2)
 *
 * @Instance
 *
 * Commands this class contains:
 *	@DefineCommand(
 *		command     = 'notes',
 *		accessLevel = 'guild',
 *		description = 'Displays, adds, or removes a note from your list',
 *		help        = 'notes.txt'
 *	)
 */
class NotesController {

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
	 * @var \Budabot\Core\Text $text
	 * @Inject
	 */
	public $text;
	
	/**
	 * @var \Budabot\Core\Modules\ALTS\AltsController $altsController
	 * @Inject
	 */
	public $altsController;
	
	/**
	 * @Setup
	 */
	public function setup() {
		$this->db->loadSQLFile($this->moduleName, "notes");
	}
	
	/**
	 * @HandlesCommand("notes")
	 * @Matches("/^notes$/i")
	 */
	public function notesListCommand($message, $channel, $sender, $sendto, $args) {
		$altInfo = $this->altsController->getAltInfo($sender);
		$main = $altInfo->getValidatedMain($sender);
		
		if ($main != $sender) {
			// convert all notes to be assigned to the main
			$sql = "UPDATE notes SET owner = ? WHERE owner = ?";
			$this->db->exec($sql, $main, $sender);
		}

		$sql = "SELECT * FROM notes WHERE owner = ? ORDER BY added_by ASC, dt DESC";
		$data = $this->db->query($sql, $main);

		if (count($data) == 0) {
			$msg = "No notes for $sender.";
		} else {
			$blob = '';
			$current = '';
			$count = count($data);
			foreach ($data as $row) {
				if ($row->added_by != $current) {
					$blob .= "\n<header2>$row->added_by<end>\n\n";
					$current = $row->added_by;
				}
				$remove = $this->text->makeChatcmd('Remove', "/tell <myname> notes rem $row->id");
				$blob .= "$remove $row->note\n\n";
			}
			$msg = $this->text->makeBlob("Notes for $sender ($count)", $blob);
		}

		$sendto->reply($msg);
	}

	/**
	 * @HandlesCommand("notes")
	 * @Matches("/^notes add (.*)$/i")
	 */
	public function notesAddCommand($message, $channel, $sender, $sendto, $args) {
		$note = $args[1];

		$altInfo = $this->altsController->getAltInfo($sender);
		$main = $altInfo->getValidatedMain($sender);

		$this->db->exec("INSERT INTO notes (owner, added_by, note, dt) VALUES (?, ?, ?, ?)", $main, $sender, $note, time());
		$msg = "Note added successfully.";

		$sendto->reply($msg);
	}
	
	/**
	 * @HandlesCommand("notes")
	 * @Matches("/^notes rem ([0-9]+)$/i")
	 */
	public function notesRemoveCommand($message, $channel, $sender, $sendto, $args) {
		$id = $args[1];
		
		$altInfo = $this->altsController->getAltInfo($sender);
		$main = $altInfo->getValidatedMain($sender);

		$numRows = $this->db->exec("DELETE FROM notes WHERE id = ? AND owner = ?", $id, $main);
		if ($numRows == 0) {
			$msg = "Note could not be found or note does not belong to you.";
		} else {
			$msg = "Note deleted successfully.";
		}

		$sendto->reply($msg);
	}
}
