<?php
namespace V108B\NetteCrud;

class Model {

	private $database;

	public function __construct(\Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function getStructure()
	{
		return $this->database->getStructure();
	}

	public function insert($tableName, array $values)
	{
		$this->getTable($tableName)->insert($values);
	}

	public function delete($tableName, $id)
	{
		$this->getRow($tableName, $id)->delete();
	}

	public function update($tableName, $id, array $values)
	{
		$this->getRow($tableName, $id)->update($values);
	}

	public function getTable($tableName)
	{
		return $this->database->table($tableName);
	}

	public function getRow($tableName, $id)
	{
		return $this->getTable($tableName)->get($id);
	}

	public function __get($name)
	{
		return $this->getTable($name);
	}
}