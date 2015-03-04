<?php

namespace App\Presenters;

class CrudPresenter extends BasePresenter {

	public function actionInsertTableRow($tableName)
	{
		$this->template->tableName = $tableName;
		$form = $this->getCrudExtenstion()->getForms()->buildInsertForm($tableName);
		$this->addComponent($form, 'crudInsertRowForm');

		$form->onSuccess[] = function() use ($tableName) {
			$this->redirect('listTable', $tableName);
		};
	}

	public function actionDeleteTableRow($tableName, $id)
	{
		$this->template->tableName = $tableName;
		$this->template->id = $id;
		$form = $this->getCrudExtenstion()->getForms()->buildDeleteForm($tableName, $id);
		$this->addComponent($form, 'crudDeleteRowForm');

		$form->onSuccess[] = function() use ($tableName) {
			$this->redirect('listTable', $tableName);
		};
	}

	public function actionUpdateTableRow($tableName, $id)
	{
		$this->template->tableName = $tableName;
		$this->template->id = $id;
		$form = $this->getCrudExtenstion()->getForms()->buildUpdateForm($tableName, $id);
		$this->addComponent($form, 'crudUpdateRowForm');

		$form->onSuccess[] = function() use ($tableName) {
			$this->redirect('listTable', $tableName);
		};
	}

	public function actionListTable($tableName)
	{
		$this['crudList'] = $this->getCrudExtenstion()->getComponents()->buildTableGrid($tableName);
	}

	/**
	 * @return \V108B\NetteCrud\Extension
	 */
	public function getCrudExtenstion()
	{
		return $this->context->getService('crud');
	}

}