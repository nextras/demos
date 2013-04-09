<?php

namespace Nextras\Demos\Datagrid;

use Nette;
use Nette\Utils\Paginator;
use Nextras;

final class FullPresenter extends BasePresenter
{
	/** @var Nette\Database\Connection @inject */
	public $connection;


	public function createComponentDatagrid()
	{
		$grid = new Nextras\Datagrid\Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('firstname')->enableSort();
		$grid->addColumn('surname')->enableSort();
		$grid->addColumn('gender')->enableSort();
		$grid->addColumn('birthday')->enableSort();
		$grid->addColumn('virtual-gender', 'Virtual gender');

		$grid->setDataSourceCallback($this->getDataSource);
		$grid->setPagination(10, $this->getDataSourceSum);
		$grid->setFilterFormFactory(function() {
			$form = new Nette\Forms\Container;
			$form->addText('firstname');
			$form->addText('surname');
			$form->addSelect('gender', NULL, array(
				'male' => 'male',
				'female' => 'female',
			))->setPrompt('---');

			return $form;
		});

		$grid->setEditFormFactory(function($row) {
			$form = new Nette\Forms\Container;
			$form->addText('firstname');
			$form->addText('surname');
			!$row ?: $form->setDefaults($row);
			return $form;
		});

		$grid->setEditFormCallback($this->saveData);

		$grid->addCellsTemplate(getNextrasDemosSource('datagrid/bootstrap-style/@bootstrap3.datagrid.latte'));
		$grid->addCellsTemplate(__DIR__ . '/../templates/Full/@cells.latte');
		return $grid;
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

	public function saveData($data)
	{
		$this->flashMessage('Saving data: ' . json_encode($data->getValues()));
		$this->invalidateControl('flashes');
	}

}
