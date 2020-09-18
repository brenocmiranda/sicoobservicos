@if(Auth::user()->email_verified_at != null)
	@include('layouts.header')

	@include('layouts.preloader')

	<div id="wrapper">
		@include('layouts.navbar')

		@include('layouts.sidebar')

		<div id="page-wrapper">
			<!-- Estrutura base da página -->
			@yield('content') 	
		</div>
	</div>

	@yield('modal') 

	@include('layouts.footer')
@else
	@include('system.new')
@endif