@if(Session::has('info') || Session::has('error') || Session::has('success'))

	<div class="alerts">
				
		@if(Session::has('error'))
			
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<i class="fa fa-times"></i>
				{{ Session::get('error')}}
			</div>
	
		@endif
	
		@if(Session::has('info'))
			
			<div class="alert alert-info alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<i class="fa fa-info"></i>
				{{ Session::get('info')}}
			</div>
	
		@endif
	
		@if(Session::has('success'))
	
			<div class="alert alert-success alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<i class="fa fa-check"></i>
				{{ Session::get('success')}}
			</div>
	
		@endif
	
	</div>

@endif