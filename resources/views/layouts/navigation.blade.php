<nav class="flex justify-between items-center">
    <div class="site-logo">
        <img src="{{ asset('images/logos/Volunteer Hub Bangladesh.png') }}" alt="Site Logo" class="logo"> <!-- Ensure this path is correct -->
    </div>

   

    <div class="nav-links flex-grow flex justify-center">
        <a href="{{ route('home') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-500' : '' }}">
            <div class="icon-container">
                <svg class="h-5 w-5 {{ request()->routeIs('home') ? 'fill-current text-blue-500' : 'fill-none' }}" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="tooltip">{{ __('Home') }}</span>
            </div>
            <div class="active-underline {{ request()->routeIs('home') ? 'active' : '' }}"></div>
        </a>
        @php
            $profileUrl = '';
            if(Auth::user()){
                $profile = Auth::user()->volunteer ?? Auth::user()->organization;
                $profileUrl = $profile ? $profile->url : '';       
            }
        @endphp
        <a href="{{ Auth::check() ? route('profile.public', $profileUrl) : route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('profile.public', Auth::id()) ? 'text-blue-500' : '' }}">
            <div class="icon-container">
                <svg class="h-5 w-5 {{ request()->routeIs('profile.public', $profileUrl) ? 'fill-current text-blue-500' : 'fill-none' }}" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="tooltip">{{ __('Profile') }}</span>
            </div>
            <div class="active-underline {{ request()->routeIs('profile.public', $profileUrl) ? 'active' : '' }}"></div>
        </a>

        <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-500' : '' }}">
            <div class="icon-container">
                <svg class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'fill-current text-blue-500' : 'fill-none' }}" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M4 4h6v6H4V4zm0 10h6v6H4v-6zm10-10h6v6h-6V4zm0 10h6v6h-6v-6z"></path>
                </svg>
                <span class="tooltip">{{ __('Dashboard') }}</span>
            </div>
            <div class="active-underline {{ request()->routeIs('dashboard') ? 'active' : '' }}"></div>
        </a>

        <!-- New Favorites Icon -->
        <a href="{{ Auth::check() ? '#' : route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                </svg>
                <span class="tooltip">{{ __('Favorites') }}</span>
            </div>
        </a>

        <!-- New Idea Board Icon -->
        <a href="{{ Auth::check() ? '#' : route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <span class="tooltip">{{ __('Idea Board') }}</span>
            </div>
        </a>
    </div>

    <!-- Logout Button on the Right -->
    <div class="logout-button">
        @auth
            <a href="{{ route('logout') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
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
            <a href="{{ route('login') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                    <span class="tooltip">{{ __('Login') }}</span>
                </div>
            </a>
            <a href="{{ route('register') }}" class="relative text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-5 w-5" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                    <span class="tooltip">{{ __('Register') }}</span>
                </div>
            </a>
        @endauth
    </div>
</nav>