<nav class="flex items-center relative">
    <div class="site-logo">
        <!-- Site logo linked to the home page -->
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logos/Volunteer Hub Bangladesh.png') }}" alt="Site Logo" class="logo"> <!-- Ensure this path is correct -->
        </a>
    </div>

    <div class="nav-links flex justify-center flex-grow">
        @auth
            <!-- Existing code for logged-in users -->
            <!-- Home link -->
            <a href="{{ route('home') }}" class="relative text-gray-500 hover:text-gray-700 icon-link">
                <div class="icon-container">
                    <!-- Hollow Home icon with active color class -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                         fill="none" 
                         stroke="currentColor" 
                         class="h-7 w-7 nav-icon {{ request()->routeIs('home') ? 'active-icon' : '' }}" 
                         viewBox="0 0 24 24">
                        <path stroke-width="1.8" d="M3 9.75L12 3l9 6.75V21a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
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
                    <x-profile-notification-dot />
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                         fill="none" 
                         stroke="currentColor" 
                         class="h-7 w-7 nav-icon {{ request()->routeIs('profile.public', $profileUrl) ? 'active-icon' : '' }}" 
                         viewBox="0 0 24 24">
                        <path stroke-width="1.8" d="M12 11a4 4 0 100-8 4 4 0 000 8zM6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/>
                    </svg>
                    
                    <span class="tooltip">{{ __('Profile') }}</span>
                    
                </div>
                <div class="active-underline {{ request()->routeIs('profile.public', $profileUrl) ? 'active' : '' }}"></div>
            </a>

            <!-- Dashboard link -->
            <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-500' : '' }}">
                <div class="icon-container">
                    <!-- Dashboard icon -->
                    @if(Auth::check() && Auth::user()->volunteer)
                        @php
                            $totalUnreadMilestones = Auth::user()->volunteer->getUnreadMilestonesCount();
                        @endphp
                        @if($totalUnreadMilestones > 0)
                            <span class="absolute top-3 right-3.5 px-1 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full border border-red-700">
                                {{ $totalUnreadMilestones }}
                            </span>
                        @endif
                    @endif
                    <svg class="h-7 w-7 nav-icon {{ request()->routeIs('dashboard') ? 'active-icon' : '' }}" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 4h6v6H4V4zm0 10h6v6H4v-6zm10-10h6v6h-6V4zm0 10h6v6h-6v-6z"></path>
                    </svg>
                    <span class="tooltip">{{ __('Dashboard') }}</span>
                </div>
                <div class="active-underline {{ request()->routeIs('dashboard') ? 'active' : '' }}"></div>
            </a>

            @if(!Auth::user()->organization) <!-- Hide favorites if logged in as an organization -->
                <!-- Favorites Icon -->
                <a href="{{ route('favorites.show') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('favorites.show') ? 'text-blue-500' : '' }}">
                    <div class="icon-container">
                        <!-- Favorites icon with active color -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                            fill="none" 
                            stroke="currentColor" 
                            class="h-7 w-7 nav-icon {{ request()->routeIs('favorites.show') ? 'active-icon' : '' }}" 
                            viewBox="0 0 24 24">
                            <path stroke-width="1.8" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="tooltip">{{ __('Favorites') }}</span>
                    </div>
                    <div class="active-underline {{ request()->routeIs('favorites.show') ? 'active' : '' }}"></div>
                </a>
            @endif

            <!-- Activity Requests link (for organizations) -->
            @if(Auth::user()->organization)
            <a href="{{ route('activity-requests.index') }}" class="relative text-gray-500 hover:text-gray-700 icon-link">
                <div class="icon-container">
                    <div class="h-7 w-7 nav-icon flex items-center justify-center">
                        <i class="fas fa-list text-lg {{ request()->routeIs('activity-requests.index') ? 'text-blue-500' : '' }}"></i>
                    </div>
                    @if(Auth::user()->organization && Auth::user()->organization->getUnreadRequestsCount() > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ Auth::user()->organization->getUnreadRequestsCount() }}
                        </span>
                    @endif
                    <span class="tooltip whitespace-nowrap">Activity Requests</span>
                </div>
                <div class="active-underline {{ request()->routeIs('activity-requests.index') ? 'active' : '' }}"></div>
            </a>
            @endif

            <!-- Search Icon - Updated with conditional display -->
            <a href="#" class="relative text-gray-500 hover:text-gray-700 icon-link" id="search-toggle" 
               style="{{ Request::is('search*') || Request::is('/') ? 'display: none;' : '' }}">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                         fill="none" 
                         stroke="currentColor" 
                         class="h-7 w-7 nav-icon" 
                         viewBox="0 0 24 24">
                        <path stroke-width="1.7" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="tooltip">{{ __('Search') }}</span>
                </div>
            </a>

            <!-- New Idea Board Icon with updated visibility conditions -->
            @if((Auth::user()->volunteer || Auth::user()->is_admin || Auth::user()->organization) && (Request::is('/') || Request::is('search*')))
                <a href="{{ route('idea_board.index') }}" class="relative text-gray-500 hover:text-gray-700 icon-link">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                             fill="{{ request()->routeIs('idea_board.index') ? 'currentColor' : 'none' }}" 
                             class="h-7 w-7 nav-icon {{ request()->routeIs('idea_board.index') ? 'active-icon' : '' }}" 
                             viewBox="0 0 16 16">
                            <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 12.93A5.93 5.93 0 1 1 8 2.07 5.93 5.93 0 0 1 8 13.93z" fill="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke-width="0.1" />
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" fill="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke="{{ request()->routeIs('idea_board.index') ? '#007bff' : 'currentColor' }}" stroke-width="0.1" />
                        </svg>
                        <span class="tooltip">{{ __('Ideas') }}</span>
                    </div>
                    <div class="active-underline {{ request()->routeIs('idea_board.index') ? 'active' : '' }}"></div>
                </a>
            @endif

        @endauth
    </div>

    <!-- Completely revised logout button -->
    <div class="logout-button">
        @auth
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-gray-500 hover:text-gray-700">
                <svg width="16" height="16" fill="currentColor" class="h-7 w-7" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" stroke-width="1.7" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                    <path fill-rule="evenodd" stroke-width="1.7" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @else
            <div class="flex items-center">
                <a href="{{ route('login') }}" class="text-blue-700 hover:text-blue-900 font-semibold px-2 py-1 text-sm">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="text-green-700 hover:text-green-900 font-semibold px-2 py-1 text-sm">
                    {{ __('Sign Up') }}
                </a>
            </div>
        @endauth
    </div>
</nav>

<!-- Updated search container div -->
<div id="search-container" class="w-full bg-white shadow-md absolute left-0 right-0 z-50" 
    style="display: {{ Request::is('search*') || Request::is('/') ? 'block' : 'none' }}; 
           transform: {{ Request::is('search*') || Request::is('/') ? 'translateY(0)' : 'translateY(-100%)' }}; 
           transition: transform 0.3s ease-out;">
    @include('search.search-bar')
</div>

<!-- Updated script -->
<script>
document.getElementById('search-toggle').addEventListener('click', function(e) {
    e.preventDefault();
    
    // Skip the animation if we're on the search or home page
    if (window.location.pathname.includes('/search') || window.location.pathname === '/') {
        return;
    }
    
    const searchContainer = document.getElementById('search-container');
    
    if (searchContainer.style.display === 'none') {
        searchContainer.style.display = 'block';
        // Force a reflow
        searchContainer.offsetHeight;
        searchContainer.style.transform = 'translateY(0)';
    } else {
        searchContainer.style.transform = 'translateY(-100%)';
        setTimeout(() => {
            searchContainer.style.display = 'none';
        }, 300);
    }
});
</script>

