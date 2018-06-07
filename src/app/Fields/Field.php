<?php

namespace Lainga9\BallDeep\app\Fields;

use Lainga9\BallDeep\app\Fields\FieldAttributes;

abstract class Field {

	protected $attributes;

	public function __construct(FieldAttributes $attributes)
	{
		$this->attributes = $attributes;
	}

	public function name()
	{
		return $this->attributes->name;
	}

	public function label()
	{
		return $this->attributes->label;
	}

	public function description()
	{
		return $this->attributes->description;
	}

	public function display($value = null)
	{
		return view(sprintf('balldeep::_partials.fields.%s', $this->attributes->type), ['field' => $this->attributes] + compact('value'))->render();
	}

}