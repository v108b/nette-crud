<?php
namespace V108B\NetteCrud;

class ComponentFactory {

	private $model;

	public $excludedFields = [];

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function buildTableGrid($tableName)
	{
		$grid = new \V108B\NetteCrud\Components\Grid();
		$grid->tableName = $tableName;
		$grid->rows = $this->model->getTable($tableName);
		$grid->model = $this->model;
		$columns = [];
		foreach ($this->model->getStructure()->getColumns($tableName) as $col) {
			if ($this->isExcluded($col['name'], $tableName)) continue;
			$columns[] = $col;
		}
		$grid->columns = $columns;

		return $grid;
	}

	public function buildInsertForm($tableName)
	{
		$structure = $this->model->getStructure();
		$form = $this->defineFormInputsByStructure($structure, $tableName);

		$form->addSubmit('saveRowSubmit', 'Save');

		$form->onSuccess[] = function($form) use ($tableName, $structure) {
			$values = $form->getValues(true);

			foreach ($structure->getColumns($tableName) as $column) {
				$name = $column['name'];

				if (
					empty($values[$name])
					&& (
						$column['autoincrement']
						|| ( self::isStringType($column['nativetype']) && ($column['nullable'] || $column['default'] !== null) )
					)
				) {
					$rowValues[$name] = null;
				} elseif (array_key_exists($name, $values)) {
					$rowValues[$name] = $values[$name];
				}
			}

			try {
				$this->model->insert($tableName, $rowValues);
			} catch (\Exception $e) {
				$form->addError($e->getMessage());
			}
		};

		return $form;
	}

	public function buildUpdateForm($tableName, $id)
	{
		$row = $this->model->getRow($tableName, $id);

		$structure = $this->model->getStructure();
		$form = $this->defineFormInputsByStructure($structure, $tableName);

		$form->addSubmit('saveRowSubmit', 'Save');

		$form->setDefaults($row);

		$form->onSuccess[] = function($form) use ($tableName, $id, $structure) {
			$values = $form->getValues(true);

			foreach ($structure->getColumns($tableName) as $column) {
				$name = $column['name'];

				if (
					empty($values[$name])
					&& ( self::isStringType($column['nativetype']) && ($column['nullable'] || $column['default'] !== null) )
				) {
					$rowValues[$name] = null;
				} elseif (array_key_exists($name, $values)) {
					$rowValues[$name] = $values[$name];
				}
			}

			try {
				$this->model->update($tableName, $id, $rowValues);
			} catch (\Exception $e) {
				$form->addError($e->getMessage());
			}
		};

		return $form;
	}

	public function buildDeleteForm($tableName, $id)
	{
		$form = new ProtectedForm();
		$form->addSubmit('deleteRowSubmit', 'Delete');

		$form->onSuccess[] = function($form) use ($tableName, $id) {
			$this->model->delete($tableName, $id);
		};
		return $form;
	}

	private static function isStringType($type) {
		return $type === 'varchar' || 'text';
	}

	private function defineFormInputsByStructure($structure, $tableName)
	{
		$columns = $structure->getColumns($tableName);
		$foreignKeys = $structure->getBelongsToReference($tableName);

		$form = new ProtectedForm();

		foreach ($columns as $column)
		{
			if ($this->isExcluded($column['name'], $tableName)) continue;

			$name = $column['name'];
			if (array_key_exists($name, $foreignKeys)) {

				$foreignTable = $this->model->getTable($foreignKeys[$name]);

				$primary = $foreignTable->getPrimary();
				$options = [];
				foreach ($foreignTable as $option)
				{
					$options[$option->$primary] = \V108B\NetteCrud\Extension::toString($option);
				}

				$select = $form->addSelect($name, $name, $options);
				if ($column['nullable']) {
					$select->setPrompt('NULL');
				}

			} elseif ($column['nativetype'] === 'TEXT') {
				$form->addTextArea($name, $name);
			} else {
				$form->addText($name, $name);
			}
		}

		return $form;
	}

	public function isExcluded($columnName, $tableName) {
		return (
			in_array($columnName, $this->excludedFields, true)
			|| (array_key_exists($tableName, $this->excludedFields)
				&& is_array($this->excludedFields[$tableName])
				&& in_array($columnName, $this->excludedFields[$tableName], true)
			)
		);
	}
}