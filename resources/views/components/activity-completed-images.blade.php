@props(['activity'])

@php
    $accomplishedPath = 'images/activities/' . $activity->activityid . '/accomplished/';
    $accomplishedFullPath = public_path($accomplishedPath);
    $accomplishedPhotos = File::exists($accomplishedFullPath) ? File::files($accomplishedFullPath) : [];
    $photoCount = count($accomplishedPhotos);
@endphp

<div class="w-full h-full">
    @if($photoCount === 0)
        <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
            <p class="text-gray-500">No images available</p>
        </div>
    @elseif($photoCount === 1)
        <img src="{{ asset($accomplishedPath . $accomplishedPhotos[0]->getFilename()) }}" alt="Accomplished Activity Photo" class="w-full h-full object-cover rounded">
    @else
        <div class="grid gap-2 w-full h-full grid-rows-2 {{ $photoCount > 3 ? 'grid-cols-3' : 'grid-cols-2' }}">
            @foreach($accomplishedPhotos as $index => $photo)
                @if($index < 5)
                    <div class="relative 
                        @if($photoCount === 2) row-span-1 col-span-2
                        @elseif($photoCount === 3 && $index === 2) col-span-2
                        @elseif($photoCount === 5 && $index < 2) col-span-3
                        @endif">
                        <img src="{{ asset($accomplishedPath . $photo->getFilename()) }}" alt="Accomplished Activity Photo" class="absolute inset-0 w-full h-full object-cover rounded">
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>