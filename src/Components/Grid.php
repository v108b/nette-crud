<?php
namespace V108B\NetteCrud\Components;

use Nette\Application\UI\Control;

class Grid extends Control
{
	private $crud;

	public $tableName;
	public $rows;
	public $structure;
	public $model;

	public function setCrudExtension($crud)
	{
		$this->crud = $crud;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/grid.latte');

		$this->template->tableName = $this->tableName;
		$this->template->rows = $this->rows;
		$this->template->model = $this->model;

		$structure = $this->structure;
		$cols = [];
		$columns = $structure->getColumns($this->tableName);
		foreach ($columns as $column) {
			$cols[] = $column['name'];
		}
		$this->template->columns = $cols;

		$this->template->foreignKeys = $structure->getBelongsToReference($this->tableName);
		$this->template->render();
	}
}