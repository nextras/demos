<?php

namespace Nextras\Demos\Datagrid;

use Nextras;
use Nextras\Demos;
use Nette;
use Nette\Utils\Paginator;

abstract class BasePresenter extends Demos\BasePresenter
{
	/** @var Nette\Database\Context @inject */
	public $context;

	public function beforeRender()
	{
		parent::beforeRender();
		$this->template->addonName = 'Datagrid';
		$this->template->addonGitHub = 'https://github.com/nextras/datagrid';
		$this->template->addonDoc = 'http://nette.merxes.cz/addons/www/nextras/datagrid';
		$this->template->addonComposer = 'nextras/datagrid';
		$this->template->addonForum = 'http://forum.nette.org/cs/13165-nextras-datagrid-datagrid-se-vsim-jak-ma-byt';

		$this->template->header = __DIR__ . '/../templates/@header.latte';
		$this->invalidateControl('flashes');
	}

	public function getDataSource($filter, $order, Paginator $paginator = NULL)
	{
		$selection = $this->prepareDataSource($filter, $order);
		if ($paginator) {
			$selection->limit($paginator->getItemsPerPage(), $paginator->getOffset());
		}
		return $selection;
	}

	public function getDataSourceSum($filter, $order)
	{
		return $this->prepareDataSource($filter, $order)->count('*');
	}

	private function prepareDataSource($filter, $order)
	{
		$filters = array();
		foreach ($filter as $k => $v) {
			if ($k === 'gender' || is_array($v))
				$filters[$k] = $v;
			else
				$filters[$k. ' LIKE ?'] = "%$v%";
		}

		$selection = $this->context->table('user')->where($filters);
		if ($order) {
			$selection->order(implode(' ', $order));
		}

		return $selection;
	}

}
