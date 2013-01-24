<?php

namespace Nextras\Demos\Forms;

use Nextras;
use Nextras\Forms\Controls;
use Nette;
use Nette\Forms\Container;

final class OptionListPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		Container::extensionMethod('addOptionList', function (Container $container, $name, $label = NULL, array $items = NULL) {
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
		$form = new Nette\Application\UI\Form;
		$form->addOptionList('list', 'Pick value', ['sci-fi', 'romantic', 'thriller', 'drama'])
			->setRequired();

		$form->addSubmit('save', 'Save');

		$form->onSuccess[] = $this->processForm;
		return $form;
	}

	public function processForm(Nette\Application\UI\Form $form)
	{
		$this->saveFormValues($form->getValues());
		$this->redirect('this');
	}

}
