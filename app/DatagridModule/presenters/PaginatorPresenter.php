<?php

namespace Nextras\Demos\Datagrid;

use Nette;
use Nette\Utils\Paginator;
use Nextras;

final class PaginatorPresenter extends BasePresenter
{
	/** @var Nette\Database\Connection @inject */
	public $connection;


	public function createComponentDatagrid()
	{
		$grid = new Nextras\Datagrid\Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('firstname');
		$grid->addColumn('surname');
		$grid->addColumn('birthday');

		$grid->setDataSourceCallback($this->getDataSource);
		$grid->setPagination(25, $this->getDataSourceSum);
		$grid->addCellsTemplate(getNextrasDemosSource('datagrid/bootstrap-style/@bootstrap3.datagrid.latte'));
		$grid->addCellsTemplate(getNextrasDemosSource('datagrid/bootstrap-style/@bootstrap3.extended-pagination.datagrid.latte'));
		return $grid;
	}

	public function getDataSource($filter, $order, Paginator $paginator)
	{
		$selection = $this->prepareDataSource($filter, $order);
		return $selection->limit($paginator->getItemsPerPage(), $paginator->getOffset());
	}

	public function getDataSourceSum($filter, $order)
	{
		return $this->prepareDataSource($filter, $order)->count('*');
	}

	private function prepareDataSource($filter, $order)
	{
		$filters = array();
		foreach ($filter as $k => $v) {
			if ($k === 'gender')
				$filters[$k] = $v;
			else
				$filters[$k. ' LIKE ?'] = "%$v%";
		}

		$selection = $this->connection->table('user')->where($filters);
		if ($order) {
			$selection->order(implode(' ', $order));
		}

		return $selection;
	}
}
