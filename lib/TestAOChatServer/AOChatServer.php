<?php

require_once 'AOChatServerPacket.php';

use Evenement\EventEmitter;

interface IAOChatModel {
	public function getAccountCharacters();
}

class AOChatServer extends EventEmitter {

	private $serverSocket;

	private $charsInfo = array();

	public $client;

	public function __construct($loop, $port) {
		$this->serverSocket = new React\Socket\Server($loop);
		$that = $this;

		$this->serverSocket->on('connection', function ($conn) use ($that) {
			print "Client connects\n";
			$that->client = $conn;
			$that->client->write($that->packetToData(new AOChatServerPacket('out', AOCP_LOGIN_SEED, 'testloginseed')));

			$that->client->on('data', function ($data) use ($that) {
				if (strlen($data) < 4) {
					print 'Error: Packet length not available\n';
					$that->client->close();
					return;
				}
				$head = substr($data, 0, 4);
				list(, $type, $len) = unpack('n2', $head);

				$data = substr($data, 4);

				$packet = new AOChatServerPacket('in', $type, $data);
				$that->emit('packet', array($packet));
			});
		});
		
		$this->on('packet', function ($packet) use ($that) {
			switch ($packet->type) {
				case AOCP_LOGIN_REQUEST:
					print "Client requests list of characters on the account when logging in\n";
					$data = array(array(), array(), array(), array());
					forEach ($that->model->getAccountCharacters() as $name) {
						$info = $that->getCharInfo($name);
						$data[0] []= $info->id;
						$data[1] []= $info->name;
						$data[2] []= $info->level;
						$data[3] []= $info->online;
					}
					$response = new AOChatServerPacket('out', AOCP_LOGIN_CHARLIST, $data);
					$that->client->write($that->packetToData($response));
					break;

				case AOCP_LOGIN_SELECT:
					$id = $packet->args[0];
					$info = $that->getCharInfo($id);
					print "Client logs in with character (id: $id): {$info->name}\n";

					$response = new AOChatServerPacket('out', AOCP_LOGIN_OK, null);
					$that->client->write($that->packetToData($response));

					$data = array(
						$info->id,
						$info->name
					);
					$response = new AOChatServerPacket('out', AOCP_CLIENT_NAME, $data);
					$that->client->write($that->packetToData($response));
					break;

				case AOCP_CLIENT_LOOKUP:
					$name = $packet->args[0];
					$info = $that->getCharInfo($name);
					$data = array(
						$info->id,
						$info->name
					);
					print "Client looks up user {$name}'s id: {$info->id}\n";
					$response = new AOChatServerPacket('out', AOCP_CLIENT_LOOKUP, $data);
					$that->client->write($that->packetToData($response));
					break;

				case AOCP_MSG_PRIVATE:
					list($gid, $msg, $blob) = $packet->args;
					print "Client sends tell message (gid: $gid): $msg, blob: $blob\n";
					$that->emit('tell_message', array($gid, $msg, $blob));
					break;

				case AOCP_PRIVGRP_MESSAGE:
					list($gid, $msg, $blob) = $packet->args;
					print "Client sends private group message (gid: $gid): $msg, blob: $blob\n";
					$that->emit('private_message', array($gid, $msg, $blob));
					break;

				case AOCP_BUDDY_ADD:
					list($uid, $type) = $packet->args;
					$info = $that->getCharInfo($uid);
					print "Client adds buddy with id $uid (type: $type, name: {$info->name})\n";
					break;

				case AOCP_PING:
					print "Client sends ping message: {$packet->args[0]}\n";
					$response = new AOChatServerPacket('out', AOCP_PING, $packet->args[0]);
					$that->client->write($that->packetToData($response));
					break;

				default:
					print "Error: Client sends unknown packet type (type: {$packet->type})\n";
					var_dump($packet);
					$that->client->close();
					break;
			}
		});
		
		$this->serverSocket->listen($port);
	}

	public function setModel(IAOChatModel $model) {
		$this->model = $model;
	}

	public function sendTellMessage($name, $message) {
		$info = $this->getCharInfo($name);
		$response = new AOChatServerPacket("out", AOCP_MSG_PRIVATE, array(
			$info->id, 
			$message, 
			"\0"
		));
		$this->client->write($this->packetToData($response));
	}

	public function addBuddy($name, $online) {
		$info = $this->getCharInfo($name);
		$info->online = $online;
		$response = new AOChatServerPacket('out', AOCP_BUDDY_ADD, array(
			$info->id,
			$online,
			'unknown value'
		));
		$this->client->write($this->packetToData($response));
	}

	public function getCharInfo($char) {
		if (!is_numeric($char)) {
			forEach ($this->charsInfo as $info) {
				if ($info->name == $char) {
					return $info;
				}
			}
			$info = new StdClass();
			$info->name   = $char;
			$info->id     = mt_rand(1, 0x7FFFFFFF);
			$info->level  = mt_rand(1, 220);
			$info->online = false;
			$this->charsInfo []= $info;
		} else {
			forEach ($this->charsInfo as $info) {
				if ($info->id == $char) {
					return $info;
				}
			}
			$info = new StdClass();
			$info->name   = "UNKNOWN";
			$info->id     = $char;
			$info->level  = mt_rand(1, 220);
			$info->online = false;
			$this->charsInfo []= $info;
		}
		return $info;
	}

	/**
	 * Converts AOChatServerPacket into a data string.
	 * Copy-pasted from AOChat's send_packet() method.
	 */
	public function packetToData($packet) {
		$data = pack("n2", $packet->type, strlen($packet->data)) . $packet->data;
		return $data;
	}
}