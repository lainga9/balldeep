@if( $errors->any() )

	<div class="alerts">
		
		<div class="alert alert-danger alert-dismissable">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<div class="container">
				
				<ul class="list list--plain">
					
					@foreach( $errors->all() as $error )
			
						<li class="list__item">{{ $error }}</li>
			
					@endforeach
			
				</ul>

			</div>
		
		</div>

	</div>

@endif