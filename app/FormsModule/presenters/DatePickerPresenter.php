<?php


namespace Nextras\Demos\Forms;

use Nextras;
use Nextras\Forms\Controls;
use Nette;
use Nette\Forms\Container;
use Nette\Application\UI\Form;

final class DatePickerPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		Container::extensionMethod('addDatePicker', function(Container $container, $name, $label = NULL) {
			return $container[$name] = new Controls\DatePicker($label);
		});
		Container::extensionMethod('addDateTimePicker', function(Container $container, $name, $label = NULL) {
			return $container[$name] = new Controls\DateTimePicker($label);
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
		$form->addDatePicker('start', 'Start date')
			->setRequired()
			->addRule($form::RANGE, 'Date must be in range.', array(new \DateTime('+1 day 00:00'), new \DateTime('+1 week 00:00')));

		$form->addDateTimePicker('start_time', 'Start datetime')
			->setRequired()
			->addRule($form::RANGE, 'Date must be in range.', array(new \DateTime('+1 day'), new \DateTime('+1 week')));

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
