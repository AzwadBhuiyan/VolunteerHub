@props(['activity'])

@php
    $accomplishedPath = 'images/activities/' . $activity->activityid . '/accomplished/';
    $accomplishedFullPath = public_path($accomplishedPath);
    $accomplishedPhotos = glob($accomplishedFullPath . '*.*');
    $photoCount = count($accomplishedPhotos);
    $carouselImages = json_encode(array_map(function($photo) use ($accomplishedPath) {
        return asset($accomplishedPath . basename($photo));
    }, $accomplishedPhotos));
@endphp

<div class="w-full h-full">
    @if($photoCount === 0)
        <div class="w-full h-full bg-gray-200 flex items-center justify-center rounded">
            <p class="text-gray-500">No images available</p>
        </div>
    @elseif($photoCount === 1)
        <img src="{{ asset($accomplishedPath . basename($accomplishedPhotos[0])) }}" 
             alt="Accomplished Activity Photo" 
             class="w-full h-full object-cover rounded clickable-image cursor-pointer" 
             data-full-src="{{ asset($accomplishedPath . basename($accomplishedPhotos[0])) }}">
    @else
        <div class="grid gap-2 w-full h-full {{ $photoCount > 2 ? 'grid-cols-2 grid-rows-2' : 'grid-cols-1 grid-rows-2' }} justify-items-center items-center">
            @foreach($accomplishedPhotos as $index => $photo)
                <div class="relative w-full h-full
                    @if($photoCount === 2) row-span-1
                    @elseif($photoCount === 3 && $index === 2) col-span-2
                    @endif">
                    <img src="{{ asset($accomplishedPath . basename($photo)) }}" 
                         alt="Accomplished Activity Photo" 
                         class="absolute inset-0 w-full h-full object-cover rounded clickable-image cursor-pointer" 
                         data-full-src="{{ asset($accomplishedPath . basename($photo)) }}" 
                         data-carousel="true"
                         data-carousel-images='{{ $carouselImages }}'>
                </div>
            @endforeach
        </div>
    @endif
</div>
