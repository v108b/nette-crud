<?php
namespace V108B\NetteCrud;

use \Nette\Database\Context;
use \Nette\Object;

class Extension extends Object{

	private $database;

	private $model;
	private $components;

	public function __construct(Context $database)
	{
		$this->database = $database;
	}

	public function setExcludedFields(array $excluded) {
		$this->getComponents()->excludedFields = $excluded;
	}

	public function getComponents() {
		if (! $this->components) {
			$this->components = new ComponentFactory($this->getModel());
		}

		return $this->components;
	}

	public function getModel() {
		if (! $this->model) {
			$this->model = new Model($this->database);
		}

		return $this->model;
	}

	public static function toString($row) {
		if (isset($row->label)) {
			return $row->label;
		} else {
			return "#" . $row->id;
		}
	}

	public static function getIdString($row) {
		$primary = $row->getPrimary();
		if (is_array($primary)) {
			return json_encode($primary);
		} else {
			return $primary;
		}
	}
}