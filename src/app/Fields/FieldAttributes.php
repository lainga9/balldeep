<?php

namespace Lainga9\BallDeep\app\Fields;

use Lainga9\BallDeep\app\MetaField;
use Lainga9\BallDeep\app\FormField;

class FieldAttributes {

	public function __construct($attributes)
	{
		if( $attributes instanceof FormField )
		{
			$this->label = $attributes->label;
			$this->name = $attributes->name;
			$this->class = $attributes->class;
			$this->required = $attributes->required;
			$this->type = $attributes->type;
			$this->options = $attributes->options;
			$this->value = $attributes->value;
			$this->placeholder = $attributes->placeholder;
			$this->description = $attributes->description;
		}
		elseif( $attributes instanceof MetaField )
		{
			$this->label = $attributes->label;
			$this->name = sprintf('meta[%s]', $attributes->name);
			$this->class = $attributes->class;
			$this->required = $attributes->required;
			$this->type = $attributes->type;
			$this->options = $attributes->options;
			$this->value = $attributes->value;
			$this->placeholder = $attributes->placeholder;
			$this->description = $attributes->description;
		}

	}

	// private function getProperty($property)
	// {
	// 	return property_exists($this->attributes, $property) ?
	// 		$this->attributes->{$property} :
	// 		'';
	// }

	// public function label()
	// {
	// 	return $this->getProperty('label');
	// }

	// public function name()
	// {
	// 	return $this->getProperty('name');
	// }

	// public function class()
	// {
	// 	return $this->getProperty('class');
	// }

	// public function type()
	// {
	// 	return $this->getProperty('type');
	// }

	// public function options()
	// {
	// 	return $this->getProperty('options');
	// }

	// public function value()
	// {
	// 	return $this->getProperty('value');
	// }

	// public function placeholder()
	// {
	// 	return $this->getProperty('placeholder');
	// }

	// public function required()
	// {
	// 	return $this->getProperty('required');
	// }
}