<?php

namespace Nextras\Demos\Forms;

use Nextras;
use Nextras\Forms\Controls;
use Nette;
use Nette\Forms\Container;
use Nette\Application\UI\Form;
use Nette\Utils\Html;

final class OptionListPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		Container::extensionMethod('addOptionList', function(Container $container, $name, $label = NULL, array $items = NULL) {
			return $container[$name] = new Controls\OptionList($label, $items);
		});
	}

	public function renderDefault()
	{
		if (isset($this->template->formValues)) {
			$this['form']->setDefaults($this->template->formValues);
		}
	}

	public function createComponentForm()
	{
		$form = new Form;
		$form->addOptionList('list', 'Pick value', ['sci-fi', 'romantic', 'thriller', 'drama'])
			->setDisabled(array(1))
			->setRequired()
			->setDefaultValue(1);

		$form->addOptionList('list2', 'Pick value rendered by object', ['sci-fi', 'romantic', 'thriller', 'drama'])
			->setDisabled(array(2))
			->setRequired();

		$form->addOptionList('list3', 'Pick value rendered by item', ['sci-fi', 'romantic', 'thriller', 'drama'])
			->setDisabled(array(3))
			->setRequired();

		$form->addSubmit('save', 'Save');

		$form->onSuccess[] = $this->processForm;
		return $form;
	}

	public function processForm(Form $form)
	{
		$this->saveFormValues($form->getValues());
		$this->redirect('this');
	}

	public function createComponentForm2()
	{
		$subjects = array(
			1 => "Artificial person",
			2 => "Natural person"
		);

		$form = new Form;
		$form->addOptionList("type", "I am", $subjects)
			->setDefaultValue(1)
			->addCondition(Form::EQUAL, 1)
				->toggle("cn")
			->elseCondition()
				->toggle("id");

		$form->addText("cn", "Company number");
		$form->addText("id", "ID card number");
		return $form;
	}

}
