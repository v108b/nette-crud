<?php
namespace V108B\NetteCrud\Components;

class ModalWindow extends \V108B\NetteModal\Window
{
	public function createComponentCrudView()
	{
		return new \V108B\NetteCrud\Components\ModalView($this);
	}

}