<x-app-layout>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-screen">
        {{-- <div class="p-1 sm:p-8 bg-white shadow sm:rounded-lg"> --}}
            @if (Auth::user()->organization)
                @include('dashboard.organization_dashboard')
            @else
                @include('dashboard.volunteer_dashboard')
            @endif
        {{-- </div> --}}
    </div>
    
</x-app-layout>