<?php

namespace Lainga9\BallDeep\app;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {

	/**
	 * Return only thos models which the given
	 * user should be able to see depending on their
	 * user role
	 * 
	 * @param  Builder $query
	 * @param  User $user
	 * @return Builder
	 */
	public function scopeVisibleTo($query, $user)
	{
		if( $user->isA('contributor') )
		{
			return $query->where('user_id', $user->id);
		}

		return $query;
	}

	/**
	 * Return models in alphabetical order
	 * 
	 * @param  Builder $query
	 * @return Builder
	 */
	public function scopeAlphabetical($query)
	{
		return $query->orderBy('name');
	}

	/**
	 * Return re-orderable models in order
	 * 
	 * @param  Builder $query
	 * @return Builder
	 */
	public function scopeInOrder($query)
	{
		return $query->orderBy('order');
	}

	/**
	 * Return models which are not equal to the given ID
	 * 
	 * @param  Builder $query
	 * @param  integer $id
	 * @return Builder
	 */
	public function scopeNot($query, $id)
	{
		if( ! $id ) return $query;
		
		return $query->where('id', '!=', $id);
	}

}