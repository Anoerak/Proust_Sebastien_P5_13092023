<?php

require_once __DIR__ . '../../Services/dbManager.php';

class MainRepository extends DbManager
{

	protected $table;
	protected $id;
	protected $column;
	protected $columnValue;
	protected $sortingOrder;
	protected $data;
	protected $db;

	public function __construct($table = null, $id = null, $column = null, $columnValue = null, $sortingOrder = null, $data = null)
	{
		$this->table = $table;
		$this->id = $id;
		$this->column = $column;
		$this->columnValue = $columnValue;
		$this->sortingOrder = $sortingOrder;
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

	public function getOneBy($datas)
	{
		$this->data = $datas;
		$query = $this->db->prepare("SELECT * FROM $this->table WHERE " . implode(' = ?, ', array_keys($this->data)) . " = ?");
		$query->execute(array_values($this->data));
		$result = $query->fetch();
		return $result;
	}

	public function getAll($column, $columnValue, $sortingOrder)
	{
		$this->column = $column;
		$this->columnValue = $columnValue;
		$this->sortingOrder = $sortingOrder;
		if ($this->columnValue !== null && $this->columnValue !== "all") {
			if ($this->sortingOrder != null) {
				$query = $this->db->prepare("SELECT * FROM $this->table WHERE $this->column = $this->columnValue ORDER BY created_at DESC");
			} else {
				$query = $this->db->prepare("SELECT * FROM $this->table WHERE $this->column = $this->columnValue ORDER BY created_at $this->sortingOrder");
			}
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

	public function create($datas)
	{
		$this->data = $datas;
		$query = $this->db->prepare("INSERT INTO $this->table (" . implode(',', array_keys($this->data)) . ") VALUES (:" . implode(',:', array_keys($this->data)) . ")");
		$query->execute($this->data);
	}

	public function update($datas)
	{
		$this->data = $datas;
		if ($this->column === null) {
			$query = $this->db->prepare("UPDATE $this->table SET " . implode(' = ?, ', array_keys($this->data)) . " = ? WHERE id = $this->id");
			$query->execute(array_values($this->data));
		} else {
			$query = $this->db->prepare("UPDATE $this->table SET " . implode(' = ?, ', array_keys($this->data)) . " = ? WHERE $this->column = $this->columnValue");
			$query->execute(array_values($this->data));
		}
	}

	public function delete()
	{
		$query = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");
		$query->execute(['id' => $this->id]);
	}

	public function getLastInsertedId()
	{
		return $this->db->lastInsertId();
	}
}
