<nav class="navbar navbar-default navbar-inverse">
	<ul class="navbar-nav nav">
		@if( !Auth::check() )
			<li class="{{ Route::currentRouteName() == 'login' ? 'active' : '' }}"><a href="{{ route('login') }}">Login</a></li>
		@else
			<li class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
			<li class="{{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" ><a href="{{ route('profile') }}">Profile</a></li>
			<li class="{{ Route::currentRouteName() == 'picks' ? 'active' : '' }}" ><a href="{{ route('picks') }}">Picks</a></li>
			<li class="{{ Route::currentRouteName() == 'standings' ? 'active' : '' }}" ><a href="{{ route('standings') }}">Standings</a></li>

			@if( Gate::allows('admin') )
				<li><a class="warning" href="#">Admin</a></li>
			@endif

			<li><a class="danger" href="{{ route('logout') }}">Logout</a></li>
		@endif
	</ul>
	
	@if( Auth::check() )
	<p class="navbar-text pull-right">Logged in as <a href="#">{{ Auth::user()->name }}</a></p>
	@endif
</nav>