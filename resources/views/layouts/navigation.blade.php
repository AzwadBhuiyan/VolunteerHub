<nav class="flex justify-between items-center">
    <div class="site-logo">
        <!-- Site logo linked to the home page -->
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logos/Volunteer Hub Bangladesh.png') }}" alt="Site Logo" class="logo"> <!-- Ensure this path is correct -->
        </a>
    </div>

    <div class="nav-links flex-grow flex justify-center">
        @auth
            <!-- Existing code for logged-in users -->
            <!-- Home link -->
            <a href="{{ route('home') }}" class="relative text-gray-500 hover:text-gray-700 icon-link">
                <div class="icon-container">
                    <!-- Hollow Home icon with active color class -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                         fill="none" 
                         stroke="currentColor" 
                         class="h-7 w-7 nav-icon {{ request()->routeIs('home') ? 'active-icon' : '' }}" 
                         viewBox="0 0 24 24">
                        <path stroke-width="2" d="M3 9.75L12 3l9 6.75V21a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                    </svg>
                    <span class="tooltip">{{ __('Home') }}</span>
                </div>
                <div class="active-underline {{ request()->routeIs('home') ? 'active' : '' }}"></div>

            </a>

            @php
                $profileUrl = '';
                // Check if user is authenticated and get profile URL
                if(Auth::user()){
                    $profile = Auth::user()->volunteer ?? Auth::user()->organization;
                    $profileUrl = $profile ? $profile->url : '';       
                }
            @endphp

            <!-- Profile link -->
            <a href="{{ Auth::check() ? route('profile.public', $profileUrl) : route('login') }}" class="relative text-gray-500 hover:text-gray-700 icon-link">
                <div class="icon-container">
                    <!-- Profile icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                         fill="{{ request()->routeIs('profile.public', $profileUrl) ? 'currentColor' : 'none' }}" 
                         class="h-7 w-7 nav-icon {{ request()->routeIs('profile.public', $profileUrl) ? 'active-icon' : '' }}" 
                         viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    <span class="tooltip">{{ __('Profile') }}</span>
                </div>
                <div class="active-underline {{ request()->routeIs('profile.public', $profileUrl) ? 'active' : '' }}"></div>
            </a>

            <!-- Dashboard link -->
            <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-500' : '' }}">
                <div class="icon-container">
                    <!-- Dashboard icon -->
                 </svg>
                    <svg class="h-7 w-7 {{ request()->routeIs('dashboard') ? 'fill-current text-blue-500' : 'fill-none' }}" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 4h6v6H4V4zm0 10h6v6H4v-6zm10-10h6v6h-6V4zm0 10h6v6h-6v-6z"></path>
                    </svg>
                    <span class="tooltip">{{ __('Dashboard') }}</span>

                </div>
                <div class="active-underline {{ request()->routeIs('dashboard') ? 'active' : '' }}"></div>
            </a>

            <!-- New Favorites Icon -->
            <a href="{{ Auth::check() ? '#' : route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                <div class="icon-container">
                    <!-- Favorites icon with active color -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                         fill="{{ request()->routeIs('home') ? '#007bff' : 'none' }}" 
                         stroke="currentColor" 
                         class="h-7 w-7 nav-icon {{ request()->routeIs('home') ? 'active-icon' : '' }}" 
                         viewBox="0 0 24 24">
                        <path stroke-width="2" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span class="tooltip">{{ __('Favorites') }}</span>
                </div>
                <div class="active-underline {{ request()->routeIs('home') ? 'active' : '' }}"></div>
            </a>

            <!-- New Idea Board Icon -->
            <a href="{{ route('idea_board.index') }}" class="relative text-gray-500 hover:text-gray-700 icon-link hide-idea-icon">
                <div class="icon-container">
                    <!-- Information icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                         fill="{{ request()->routeIs('idea_board.index') ? 'currentColor' : 'none' }}" 
                         class="h-7 w-7 nav-icon {{ request()->routeIs('idea_board.index') ? 'active-icon' : '' }}" 
                         viewBox="0 0 16 16">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 12.93A5.93 5.93 0 1 1 8 2.07 5.93 5.93 0 0 1 8 13.93z" fill="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke-width="0.5" />
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" fill="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke-width="0.5" />
                    </svg>
                    <span class="tooltip">{{ __('Ideas') }}</span>
                </div>
                <div class=" active-underline {{ request()->routeIs('idea_board.index') ? 'active' : '' }}"></div>
            </a>

           
        @endauth
    </div>

    <div class="logout-button flex items-center mobile-logout"> <!-- Added class mobile-logout -->
        @auth
            <!-- Existing logout button code -->
            <a href="{{ route('logout') }}" class=" relative text-gray-500 hover:text-gray-700 px-1 py-1 rounded-md text-sm font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="icon-container">
                    <!-- Logout icon -->
                    <svg width="16" height="16" fill="currentColor" class="h-7 w-7" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                    <span class="tooltip">{{ __('Logout') }}</span>
                </div>
                <div class="active-underline"></div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <!-- Only show login and register for guests on the right side -->
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md font-bold">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="text-green-500 font-bold px-3 py-2 rounded-md">
                    {{ __('signup') }}
                </a>
            </div>
        @endauth
    </div>
</nav>