<?php

namespace App\Presenters;

class CrudPresenter extends BasePresenter {

	public function actionInsertTableRow($tableName, $defaults = null)
	{
		$this->template->tableName = $tableName;
		$form = $this->getCrudExtenstion()->getForms()->buildInsertForm($tableName);
		if ($defaults) {
			$form->setDefaults(json_decode($defaults, true));
		}
		$this->addComponent($form, 'crudInsertRowForm');

		$form->onSuccess[] = function() use ($tableName) {
			$this->redirect('listTable', $tableName);
		};
	}

	public function actionUpdateTableRow($tableName, $id, $defaults = null)
	{
		$this->template->tableName = $tableName;
		$this->template->id = $id;
		$form = $this->getCrudExtenstion()->getForms()->buildUpdateForm($tableName, json_decode($id, true));
		if ($defaults) {
			$form->setDefaults(json_decode($defaults, true));
		}
		$this->addComponent($form, 'crudUpdateRowForm');

		$form->onSuccess[] = function() use ($tableName) {
			$this->redirect('listTable', $tableName);
		};
	}

	public function actionDeleteTableRow($tableName, $id)
	{
		$this->template->tableName = $tableName;
		$this->template->id = $id;
		$form = $this->getCrudExtenstion()->getForms()->buildDeleteForm($tableName, json_decode($id, true));
		$this->addComponent($form, 'crudDeleteRowForm');

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
