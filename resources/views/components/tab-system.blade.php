<div x-data="{ activeTab: '{{ $defaultTab }}' }">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex">
            @foreach($tabs as $tabKey => $tabName)
                <button @click="activeTab = '{{ $tabKey }}'" 
                        :class="{'border-indigo-500 text-indigo-600': activeTab === '{{ $tabKey }}'}"
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    {{ $tabName }}
                </button>
            @endforeach
        </nav>
    </div>
    <div>
        @foreach($tabs as $tabKey => $tabName)
            <div x-show="activeTab === '{{ $tabKey }}'">
                {{ ${$tabKey} }}
            </div>
        @endforeach
    </div>
</div>