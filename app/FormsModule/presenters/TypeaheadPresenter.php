<?php

namespace Nextras\Demos\Forms;

use Nextras;
use Nextras\Forms\Controls;
use Nette;
use Nette\Forms\Container;
use Nette\Application\UI\Form;
use Nette\Utils\Html;

final class TypeaheadPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		Container::extensionMethod('addTypeahead', function(Container $container, $name, $label = NULL, $callback = NULL) {
			$control = new Controls\Typeahead($label, $callback);
			return $container[$name] = $control;
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
		$form->addTypeahead('autocomplete', 'Day', function($query) {
			$send = [];
			$data = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
			foreach ($data as $value) {
				if (strpos($value, $query) !== FALSE) {
					$send[] = $value;
				}
			}
			return $send;
		});

		$form->addSubmit('save', 'Save');
		$form->setRenderer(new Nextras\Forms\Rendering\Bs3FormRenderer);
		$form->onSuccess[] = $this->processForm;
		return $form;
	}

	public function processForm(Form $form)
	{
		$this->saveFormValues($form->getValues());
		$this->redirect('this');
	}

}
