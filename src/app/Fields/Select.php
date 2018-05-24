<?php

namespace Lainga9\BallDeep\app\Fields;

use Lainga9\BallDeep\app\MetaField;

class Select extends Field {

	protected $field;

	public function __construct(MetaField $field)
	{
		parent::__construct($field);
	}
}