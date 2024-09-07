<div>
    @foreach($activities as $activity)
        <div class="mb-4 p-4 border rounded">
            <h4 class="font-semibold">{{ $activity->title }}</h4>
            <p class="text-sm text-gray-600">{{ $activity->date }}</p>
            <p>{{ Str::limit($activity->description, 100) }}</p>
        </div>
    @endforeach
</div>