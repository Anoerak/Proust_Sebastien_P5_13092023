<?php

require_once __DIR__ . '../../Services/dbManager.php';

/*
	We need the following methods:
	- getOne ($id or $filter)
	- getAll ($id)
	- add
	- update ($id)
	- delete ($id)
	- getPrivilege ($id)
	- validateComment ($id)
	- refuseComment ($id)
	- subscribe
	- unsubscribe
*/

class MainRepository extends dbManager
{

	protected $table;
	protected $id;
	protected $filter;
	protected $data;
	protected $db;

	public function __construct($table = null, $id = null, $filter = null, $data = null)
	{
		$this->table = $table;
		$this->id = $id;
		$this->filter = $filter;
		$this->data = $data;
		$this->db = $this->dbConnect();
	}

	public function getOne($id)
	{
		$this->id = $id;
		$query = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
		$query->execute(['id' => $this->id]);
		$result = $query->fetch();
		return $result;
	}

	public function getAll($filter)
	{
		$this->filter = $filter;
		if ($this->filter != null && $this->filter != "all") {
			$query = $this->db->prepare("SELECT * FROM $this->table WHERE category = $this->filter ORDER BY created_at DESC");
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		} else {
			$query = $this->db->prepare("SELECT * FROM $this->table ORDER BY created_at DESC");
			$query->execute();
			$result = $query->fetchAll();
			return $result;
		}
	}

	public function add($datas)
	{
		$this->data = $datas;
		$query = $this->db->prepare("INSERT INTO $this->table (" . implode(',', array_keys($this->data)) . ") VALUES (:" . implode(',:', array_keys($this->data)) . ")");
		$query->execute($this->data);
	}

	public function update($datas)
	{
		$this->data = $datas;
		$query = $this->db->prepare("UPDATE $this->table SET " . implode(' = ?, ', array_keys($this->data)) . " = ? WHERE id = $this->id");
		$query->execute(array_values($this->data));
	}

	public function delete()
	{
		$query = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");
		$query->execute(['id' => $this->id]);
	}

	public function getPrivilege($id)
	{
		$this->id = $id;
		$query = $this->db->prepare("SELECT privilege FROM $this->table WHERE id = :id");
		$query->execute(['id' => $this->id]);
		$result = $query->fetch();
		return $result;
	}

	public function validateComment($id)
	{
		$this->id = $id;
		$query = $this->db->prepare("UPDATE $this->table SET validated = 1 WHERE id = :id");
		$query->execute(['id' => $this->id]);
	}

	public function refuseComment($id)
	{
		$this->id = $id;
		$query = $this->db->prepare("UPDATE $this->table SET validated = 0 WHERE id = :id");
		$query->execute(['id' => $this->id]);
	}

	public function subscribe($id)
	{
		$this->id = $id;
		$query = $this->db->prepare("UPDATE $this->table SET subscribed = 1 WHERE id = :id");
		$query->execute(['id' => $this->id]);
	}

	public function unsubscribe($id)
	{
		$this->id = $id;
		$query = $this->db->prepare("UPDATE $this->table SET subscribed = 0 WHERE id = :id");
		$query->execute(['id' => $this->id]);
	}

	public function getLastInsertedId()
	{
		$query = $this->db->prepare("SELECT id FROM $this->table ORDER BY id DESC LIMIT 1");
		$query->execute();
		$result = $query->fetch();
		return $result;
	}
}
