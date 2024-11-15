@if(auth()->user()->volunteer && auth()->user()->volunteer->isProfileIncomplete())
    <div class="absolute top-0 right-0 h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
        <span class="absolute inline-flex rounded-full h-3 w-3 bg-red-500"></span>
    </div>
@endif