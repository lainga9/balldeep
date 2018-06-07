@extends('balldeep::layout')

@section('title', 'Site Settings')

@section('content')

	<form action="{!! route('balldeep.admin.settings.update') !!}" method="POST">
		
		{!! csrf_field() !!}

		<div class="row mb-4">
			
			<div class="col-lg-8">

				<div class="box box--white box--bordered elem--shadow mb-3">

					<div class="form-group">
						<label class="form-label">Site Email</label>
						<input type="hidden" name="settings[site_email][type]" value="string">
						<input type="email" name="settings[site_email][string]" class="form-control" value="{!! old('settings.email.string', BallDeep::siteEmailAddress()) !!}">
					</div>

				</div>

				<div class="box box--white box--bordered elem--shadow mb-3">

					<div class="form-group">
						<label class="form-label">Twitter Handle</label>
						<input type="hidden" name="settings[twitter_handle][type]" value="string">
						<input type="text" name="settings[twitter_handle][string]" class="form-control" value="{!! old('settings.twitter_handle.string', BallDeep::setting('twitter_handle')) !!}">
					</div>

				</div>

				<div class="box box--white box--bordered elem--shadow mb-3">

					<div class="form-group">
						<label class="form-label">Twitter URL</label>
						<input type="hidden" name="settings[twitter_url][type]" value="string">
						<input type="text" name="settings[twitter_url][string]" class="form-control" value="{!! old('settings.twitter_url.string', BallDeep::setting('twitter_url')) !!}">
					</div>

				</div>

				<div class="box box--white box--bordered elem--shadow mb-3">

					<div class="form-group">
						<label class="form-label">Facebook URL</label>
						<input type="hidden" name="settings[facebook_url][type]" value="string">
						<input type="text" name="settings[facebook_url][string]" class="form-control" value="{!! old('settings.facebook_url.string', BallDeep::setting('facebook_url')) !!}">
					</div>

				</div>

				<div class="box box--white box--bordered elem--shadow mb-3">

					<div class="form-group">
						<label class="form-label">LinkedIn URL</label>
						<input type="hidden" name="settings[linkedin_url][type]" value="string">
						<input type="text" name="settings[linkedin_url][string]" class="form-control" value="{!! old('settings.linkedin_url.string', BallDeep::setting('linkedin_url')) !!}">
					</div>

				</div>
				
			</div>

		</div>

		<button type="submit" class="btn btn-primary">Update Settings</button>

	</form>

@stop