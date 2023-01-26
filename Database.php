<?php

class DB {
	private static $instance;
	
    public $pdo;

	public $register;
	public $getPassword;
    public $sendMessage;
    public $history;
    public $markAsDeleted;
	public $edit;
	public $now;
	public $historyAfter;
	public $deleteAccount;
	public $chatDeleteAccount;

    private function __construct($config) {
        try {
			$this->pdo = new PDO(
				'mysql:host='.$config['host'].';dbname='.$config['dbname'].';port='.$config['port'],
				$config['username'],
				$config['password'],
				[
					PDO::ATTR_PERSISTENT => true,
					PDO::ATTR_TIMEOUT => 1,
				]
			);
		} catch (Exception $e) {
			die($e->getMessage());
		}

		$this->now = $this->pdo->prepare('SELECT now(3)');
		$this->register = $this->pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        $this->getPassword = $this->pdo->prepare('SELECT password FROM users WHERE username = :username');
        $this->sendMessage = $this->pdo->prepare('INSERT INTO chat (id, username, message, time) VALUES (NULL, :username, :message , now(3))');
		$this->history = $this->pdo->prepare('SELECT id, time, username, message, edit_time FROM chat WHERE delete_time IS NULL ORDER BY time ASC LIMIT 100');
		$this->historyAfter = $this->pdo->prepare('SELECT id, time, username, message, edit_time, delete_time FROM chat WHERE time > :time OR edit_time > :time OR delete_time > :time ORDER BY delete_time, edit_time, time ASC LIMIT 100');
		$this->markAsDeleted = $this->pdo->prepare('UPDATE chat SET delete_time = now(3) WHERE id = :id AND username = :username');
        $this->edit = $this->pdo->prepare('UPDATE chat SET edit_time = now(3), message = :message WHERE id = :id AND username = :username');
		$this->deleteAccount = $this->pdo->prepare('DELETE FROM users WHERE username = :username');
		$this->chatDeleteAccount = $this->pdo->prepare('UPDATE chat SET username="Deleted" WHERE username = :username');
	}

	public static function get() {
		if (!isset(self::$instance)) {
			self::$instance = new DB([
				'host' => 'localhost',
			    'port' => 3306, // 3306,
				'dbname' => 'surname',
			    'username' => 'root',
			    'password' => '',
			]);
		}

		return self::$instance;
	}
}

?>