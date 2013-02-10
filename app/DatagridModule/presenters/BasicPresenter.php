<?php

namespace Nextras\Demos\Datagrid;

use Nette;
use Nextras;

final class BasicPresenter extends BasePresenter
{

	/** @var Nette\Database\Connection */
	private $connection;

	public function injectConnection(Nette\Database\Connection $connection)
	{
		$this->connection = $connection;
	}

	public function createComponentDatagrid()
	{
		$grid = new Nextras\Datagrid\Datagrid;
		$grid->addColumn('id');
		$grid->addColumn('firstname')->enableSort();
		$grid->addColumn('surname')->enableSort();
		$grid->addColumn('gender')->enableSort();
		$grid->addColumn('birthday')->enableSort();
		$grid->addColumn('virtual-gender', 'Virtual gender');

		$grid->setDataSourceCallback($this->getData);

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
		$grid->addCellsTemplate(__DIR__ . '/../templates/Basic/@cells.latte');
		return $grid;
	}

	public function getData($filter, $order)
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

		return $selection->limit(30);
	}

	public function saveData($data)
	{
		$this->flashMessage('Saving data: ' . json_encode($data->getValues()));
		$this->invalidateControl('flashes');
	}

}
