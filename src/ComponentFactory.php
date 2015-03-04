<?php
namespace V108B\NetteCrud;

class ComponentFactory {

	private $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function buildTableGrid($tableName)
	{
		$grid = new \V108B\NetteCrud\Components\Grid();
		$grid->tableName = $tableName;
		$grid->rows = $this->model->getTable($tableName);
		$grid->structure = $this->model->getStructure();
		$grid->model = $this->model;

		return $grid;
	}
}