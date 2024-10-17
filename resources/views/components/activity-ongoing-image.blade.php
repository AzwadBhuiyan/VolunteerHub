@props(['activity'])

@php
    $imagePath = 'images/activities/' . $activity->activityid . '/';
    $imageFullPath = public_path($imagePath);
    $imageFiles = File::exists($imageFullPath) ? File::files($imageFullPath) : [];
    $imageExists = !empty($imageFiles);
    $imageSrc = $imageExists ? asset($imagePath . basename($imageFiles[0])) : asset('images/defaults/default-activity.jpg');
@endphp

@if($imageExists)
    <div class="aspect-w-1 aspect-h-1">
        <img src="{{ $imageSrc }}" 
             alt="{{ $activity->title }}" 
             class="object-cover w-full h-full rounded clickable-image cursor-pointer" 
             data-full-src="{{ $imageSrc }}">
    </div>
@else
    <div class="aspect-w-1 aspect-h-1 bg-gray-200 flex items-center justify-center rounded">
        <img src="{{ $imageSrc }}" alt="Default Activity Image" class="object-cover w-full h-full rounded">
        
    </div>
@endif