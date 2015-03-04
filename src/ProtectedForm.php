<?php
namespace V108B\NetteCrud;

use Nette\Application\UI\Form;

class ProtectedForm extends Form
{
	public function __construct($parent = null, $name = null)
	{
		parent::__construct($parent, $name);
		$this->addProtection('Form expired. Please retry');
	}
}
