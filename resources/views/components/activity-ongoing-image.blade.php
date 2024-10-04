@props(['activity'])

@php
    $imagePath = 'images/activities/' . $activity->activityid . '/' . $activity->activityid . '.jpg';
    $fullImagePath = public_path($imagePath);
    $imageExists = file_exists($fullImagePath);
@endphp

@if($imageExists)
    <div class="aspect-w-1 aspect-h-1">
        <img src="{{ asset($imagePath) }}" 
             alt="{{ $activity->title }}" 
             class="object-cover w-full h-full rounded clickable-image cursor-pointer" 
             data-full-src="{{ asset($imagePath) }}">
    </div>
@else
    <div class="aspect-w-1 aspect-h-1 bg-gray-200 flex items-center justify-center rounded">
        <p class="text-gray-500">No image available</p>
    </div>
@endif