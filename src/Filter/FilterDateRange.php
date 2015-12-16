<?php

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\DataGrid\Filter;

use Nette;

class FilterDateRange extends Filter
{

	/**
	 * @var array
	 */
	private $placeholder;

	/**
	 * @var string
	 */
	private $name_second;

	/**
	 * @var string
	 */
	protected $template = 'datagrid_filter_daterange.latte';


	public function __construct($key, $name, $column, $name_second)
	{
		parent::__construct($key, $name, $column);

		$this->name_second = $name_second;
	}


	/**
	 * Adds select box to filter form
	 * @param Nette\Application\UI\Form $form
	 */
	public function addToForm($form)
	{
		$container = $form->addContainer($this->key);

		$container->addText('from', $this->name)
			->setAttribute('data-datepicker');

		$container->addText('to', $this->name_second)
			->setAttribute('data-datepicker');

		if ($placeholder = $this->getPlaceholder()) {
			if ($text_from = reset($placeholder)) {
				$form[$this->key]['from']->setAttribute('placeholder', $text_from);
			}

			if ($text_to = end($placeholder) && $text_to != $text_from) {
				$form[$this->key]['to']->setAttribute('placeholder', $text_to);
			}
		}
	}


	/**
	 * Set html attr placeholder of both fields
	 * @param string $placeholder
	 */
	public function setPlaceholder($placeholder)
	{
		if (!is_array($placeholder)) {
			throw new FilterDateRangeException(
				'FilterDateRange::setPlaceholder can only accept array of placeholders'
			);
		}

		$this->placeholder = $placeholder;

		return $this;
	}


	public function getCondition()
	{
		$value = $this->getValue();

		return [$this->column => [
			'from' => $value['from'],
			'to' => $value['to']
		]];
	}

}


class FilterDateRangeException extends \Exception
{
}
