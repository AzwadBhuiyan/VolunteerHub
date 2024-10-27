@props(['activity', 'isOrganizer' => false])

<div class="bg-white rounded-lg shadow-md p-4 mt-4">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Activity Timeline</h3>
        @if ($isOrganizer && $activity->status !== 'completed')
            <button 
                onclick="document.getElementById('newMilestoneModal').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm">
                Add Milestone
            </button>
        @endif
    </div>

    <div class="relative">
        <!-- Timeline line -->
        <div class="absolute left-1/2 top-0 bottom-0 w-0.5 bg-gray-300 transform -translate-x-1/2"></div>

        <!-- Timeline items -->
        <div class="space-y-8">
            @forelse ($activity->milestones as $milestone)
                <div class="relative flex items-center justify-center">
                    <!-- Timeline dot -->
                    <div class="absolute left-1/2 w-4 h-4 rounded-full border-2 border-blue-500 bg-white transform -translate-x-1/2"></div>
                    
                    <!-- Content -->
                    <div class="w-5/12 pr-8 text-right">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $milestone->message }}</p>
                    </div>
                    
                    <div class="w-5/12 pl-8">
                        <span class="text-sm text-gray-500">{{ $milestone->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 italic">No milestones yet.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- New Milestone Modal -->
@if ($isOrganizer && $activity->status !== 'completed')
    <div id="newMilestoneModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form action="{{ route('activities.milestones.store', $activity) }}" method="POST">
                @csrf
                <h3 class="text-lg font-semibold mb-4">Add New Milestone</h3>
                <textarea 
                    name="message" 
                    rows="4" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                    placeholder="Enter milestone message"></textarea>
                
                <div class="mt-4 flex justify-end space-x-3">
                    <button 
                        type="button"
                        onclick="document.getElementById('newMilestoneModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
