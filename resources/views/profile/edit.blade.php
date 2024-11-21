<x-app-layout>
   
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($user->volunteer)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg ">
                    <div class="mx-auto max-w-2xl">
                        @include('profile.partials.update-volunteer-information-form')
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg ">
                    <div class="mx-auto max-w-2xl">
                        @include('profile.partials.update-volunteer-additional-info-form')
                    </div>
                </div>

            @elseif($user->organization)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="mx-auto max-w-2xl">
                        @include('profile.partials.update-organization-information-form')
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="mx-auto max-w-2xl">
                        @include('profile.partials.update-organization-additional-info-form')
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mx-auto max-w-2xl">
                    @include('profile.partials.update-security-settings-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mx-auto max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mx-auto max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    @if(!empty($logMessages))
    <script>
        window.addEventListener('load', function() {
            var messages = @json($logMessages);
            messages.forEach(function(msg) {
                if (msg.type === 'error') {
                    console.error(msg.message, msg.data);
                } else {
                    console.log(msg.message, msg.data);
                }
            });
        });
    </script>
@endif


</x-app-layout>
