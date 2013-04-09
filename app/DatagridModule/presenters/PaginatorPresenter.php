<?php

namespace Nextras\Demos\Datagrid;

use Nette;
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

}
