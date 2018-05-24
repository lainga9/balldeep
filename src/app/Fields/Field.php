<?php

namespace Lainga9\BallDeep\app\Fields;

use Lainga9\BallDeep\app\MetaField;

abstract class Field {

	protected $field;

	public function __construct(MetaField $field)
	{
		$this->field = $field;
	}

	public function label()
	{
		return $this->field->label;
	}

	public function display($value = null)
	{
		return view(sprintf('balldeep::_partials.fields.%s', $this->field->type), ['field' => $this->field] + compact('value'))->render();
	}

}