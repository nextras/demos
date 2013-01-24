<?php

namespace Nextras\Demos\Application;

use Nextras;
use Nextras\Demos;

abstract class BasePresenter extends Demos\BasePresenter
{

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->addonName = 'Application';
		$this->template->addonGitHub = 'https://github.com/nextras/application';
		$this->template->addonComposer = 'nextras/application';
	}

}
