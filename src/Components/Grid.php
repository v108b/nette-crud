<?php
namespace V108B\NetteCrud\Components;

use Nette\Application\UI\Control;
use Nette\NotImplementedException;

class Grid extends Control
{
	public $tableName;
	public $rows;
	public $model;
	public $columns;

	public function render(ModalView $crudView = null)
	{
		if ($crudView) {
			$this->template->crudView = $crudView;
		} else {
			throw new NotImplementedException('CrudViewFake not implemented');
		}

		$this->template->setFile(__DIR__ . '/grid.latte');
		$this->template->tableName = $this->tableName;
		$this->template->rows = $this->rows;
		$this->template->model = $this->model;

		$this->template->columns = [];
		foreach ($this->columns as $column) {
			$this->template->columns[] = $column['name'];
		}

		$this->template->foreignKeys = $this->model->getStructure()->getBelongsToReference($this->tableName);
		$this->template->render();
	}
}