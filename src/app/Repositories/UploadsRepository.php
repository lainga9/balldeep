<?php

namespace Lainga9\BallDeep\app\Repositories;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Storage;

class UploadsRepository {

	public function uploadFile(UploadedFile $file, $path = '', $name = null, $public = true)
	{
		$name = $name ?: $file->getClientOriginalName();

		if( $public )
		{
			return Storage::disk('public')->putFileAs($path, $file, $name, $public);
		}
		else
		{
			return Storage::putFileAs($path, $file, $name, $public);
		}
	}

}