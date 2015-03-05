<?php

namespace App\Presenters;

class CrudPresenter extends BasePresenter {

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
