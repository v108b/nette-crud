<?php

namespace V108B\NetteCrud\Components;

class ModalView extends \V108B\NetteModal\View {

	/** @persistent */
	public $action;

	/** @persistent */
	public $tableName;

	/** @persistent */
	public $id;

	/** @persistent */
	public $defaults;

	public function getTitle()
	{
		return 'Crud: ' . $this->action . ' ' . $this->tableName;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/modalView.latte');
		$this->template->action = $this->action;
		$this->template->render();
	}

	public function createComponentCrudInsertForm()
	{
		$form = $this->getCrudExtension()->getComponents()->buildInsertForm($this->tableName);
		if ($this->defaults) {
			$form->setDefaults(json_decode($this->defaults, true));
		}

		$form->onSuccess[] = function() {$this->getWindow()->close();};
		return $form;
	}

	public function createComponentCrudUpdateForm()
	{
		$form = $this->getCrudExtension()->getComponents()->buildUpdateForm($this->tableName, json_decode($this->id, true));
		if ($this->defaults) {
			$form->setDefaults(json_decode($this->defaults, true));
		}

		$form->onSuccess[] = function() {$this->getWindow()->close();};
		return $form;
	}

	public function createComponentCrudDeleteForm()
	{
		$form = $this->getCrudExtension()->getComponents()->buildDeleteForm($this->tableName, json_decode($this->id, true));

		$form->onSuccess[] = function() {$this->getWindow()->close();};
		return $form;
	}

	public function handleInsert($tableName, $defaults = null)
	{
		$this->action = 'insert';
		$this->tableName = $tableName;
		$this->defaults = $defaults;
		$this->getWindow()->showView($this);
	}

	public function handleUpdate($tableName, $id, $defaults = null)
	{
		$this->action = 'update';
		$this->tableName = $tableName;
		$this->id = $id;
		$this->defaults = $defaults;
		$this->getWindow()->showView($this);
	}

	public function handleDelete($tableName, $id)
	{
		$this->action = 'delete';
		$this->tableName = $tableName;
		$this->id = $id;
		$this->getWindow()->showView($this);
	}

	private function getCrudExtension()
	{
		return $this->presenter->context->getService('crud');
	}

}