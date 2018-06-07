<?php

namespace Lainga9\BallDeep\app\Fields;

use Lainga9\BallDeep\app\Fields\FieldAttributes;

class Textarea extends Field {

	protected $attributes;

	public function __construct(FieldAttributes $attributes)
	{
		parent::__construct($attributes);
	}
}