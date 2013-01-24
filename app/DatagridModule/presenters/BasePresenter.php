<?php

namespace Nextras\Demos\Datagrid;

use Nextras;
use Nextras\Demos;

abstract class BasePresenter extends Demos\BasePresenter
{

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->addonName = 'Datagrid';
		$this->template->addonGitHub = 'https://github.com/nextras/datagrid';
		$this->template->addonDoc = 'http://nette.merxes.cz/addons/www/nextras/datagrid';
		$this->template->addonComposer = 'nextras/datagrid';
		$this->template->addonForum = 'http://forum.nette.org/cs/13165-nextras-datagrid-datagrid-se-vsim-jak-ma-byt';

		$this->template->header = __DIR__ . '/../templates/@header.latte';
	}

}
