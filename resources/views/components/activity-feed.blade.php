<div>
    @if (session('success'))
        <div class="max-w-3xl mx-auto px-4 py-3 mb-4 bg-green-100 text-green-700 border border-green-400 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
        @foreach($activities as $activity)
            <x-activity-card :activity="$activity" />
        @endforeach

        <div class="mt-8">
            {{ $activities->links() }}
        </div>
    </div>
</div>