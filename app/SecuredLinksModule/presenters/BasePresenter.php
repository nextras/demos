<?php

namespace Nextras\Demos\SecuredLinks;

use Nextras;
use Nextras\Demos;

abstract class BasePresenter extends Demos\BasePresenter
{

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->addonName = 'SecuredLinks';
		$this->template->addonGitHub = 'https://github.com/nextras/secured-links';
		$this->template->addonComposer = 'nextras/secured-links';
	}

}
