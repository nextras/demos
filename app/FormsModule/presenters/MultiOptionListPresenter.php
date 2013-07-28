<?php

namespace Nextras\Demos\Forms;

use Nextras;
use Nextras\Forms\Controls;
use Nette;
use Nette\Forms\Container;
use Nette\Application\UI\Form;

final class MultiOptionListPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		Container::extensionMethod('addMultiOptionList', function(Container $container, $name, $label = NULL, array $items = NULL) {
			return $container[$name] = new Controls\MultiOptionList($label, $items);
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
		$form->addMultiOptionList('list', 'Pick value 1.', ['sci-fi', 'romantic', 'thriller', 'drama'])
			->setDisabled(array(1))
			->setRequired()
			->setDefaultValue(array(0, 1, 2));

		$form->addMultiOptionList('list2', 'Pick value 2.', ['sci-fi', 'romantic', 'thriller', 'drama'])
			->setDisabled(array(2))
			->addRule(Form::MIN_LENGTH, 'Pick at least two options.', 2);

		$form->addMultiOptionList('list3', 'Pick value 3.', ['sci-fi', 'romantic', 'thriller', 'drama'])
			->setDisabled(array(3))
			->addRule(Form::LENGTH, 'Pick zero, one or two options.', array(0, 2));

		$form->addSubmit('save', 'Save');

		$form->onSuccess[] = $this->processForm;
		return $form;
	}

	public function processForm(Form $form)
	{
		$this->saveFormValues($form->getValues());
		$this->redirect('this');
	}

}
