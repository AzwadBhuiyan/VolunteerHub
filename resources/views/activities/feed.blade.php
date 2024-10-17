<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activities Feed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <x-activity-feed :activities="$activities" />
    </div>

    <x-image-popup />
</x-public-layout>