<?php

namespace Nextras\Demos\Forms;

use Nextras;
use Nextras\Demos;

abstract class BasePresenter extends Demos\BasePresenter
{

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->addonName = 'Forms';
		$this->template->addonGitHub = 'https://github.com/nextras/forms';
		$this->template->addonDoc = '';
		$this->template->addonComposer = 'nextras/forms';

		$this->template->header = __DIR__ . '/../templates/@header.latte';

		$this->template->formValues = $this->restoreFormValues();
	}

	protected function saveFormValues($values)
	{
		$this->session->getSection(__CLASS__)->values = $values;
	}

	protected function restoreFormValues()
	{
		$values = $this->session->getSection(__CLASS__)->values;
		unset($this->session->getSection(__CLASS__)->values);
		return $values;
	}

}
