<?php

namespace Lainga9\BallDeep\app\Fields;

use Lainga9\BallDeep\app\Fields\FieldAttributes;
use Exception;

class FieldFactory {

	public static function getField(FieldAttributes $attributes)
	{
		if( ! $attributes || ! $attributes->type  )
		{
			throw new Exception('Field type not specified!');
		}

		$name = ucwords($attributes->type);

		$name = 'Lainga9\BallDeep\app\Fields\\' . $name;

		if( ! class_exists($name) )
		{
			throw new Exception(sprintf('Field %s not found!', $attributes->type));
		}

		return new $name($attributes);
	}

}