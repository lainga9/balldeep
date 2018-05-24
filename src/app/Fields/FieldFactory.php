<?php

namespace Lainga9\BallDeep\app\Fields;

use Lainga9\BallDeep\app\MetaField;

use Exception;

class FieldFactory {

	public static function getField(MetaField $field)
	{
		if( ! $field || ! $field->type  )
		{
			throw new Exception('Field type not specified!');
		}

		$name = ucwords($field->type);

		$name = 'Lainga9\BallDeep\app\Fields\\' . $name;

		if( ! class_exists($name) )
		{
			throw new Exception(sprintf('Field %s not found!', $field->type));
		}

		return new $name($field);
	}

}