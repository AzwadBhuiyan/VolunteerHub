<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Timeline: {{ $activity->title }}
            </h2>
            <a href="{{ route('activities.show', $activity) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">
                Back to Activity
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-activity-timeline 
                        :activity="$activity" 
                        :isOrganizer="Auth::id() === $activity->userid" 
                    />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>