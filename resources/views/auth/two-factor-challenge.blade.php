<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please enter the OTP code sent to your email to complete login.') }}
    </div>

    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <div>
            <x-input-label for="code" :value="__('OTP Code')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <button type="button" 
                id="resendButton" 
                class="text-sm text-gray-600 hover:text-gray-900 disabled:opacity-50"
                disabled>
                {{ __('Resend OTP') }}
                <span id="timer">(60s)</span>
            </button>
            <x-primary-button>{{ __('Verify') }}</x-primary-button>
        </div>
    </form>

    <script>
        let timeLeft = 60;
        const timerSpan = document.getElementById('timer');
        const resendButton = document.getElementById('resendButton');

        const countdown = setInterval(() => {
            timeLeft--;
            timerSpan.textContent = `(${timeLeft}s)`;
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                resendButton.disabled = false;
                timerSpan.textContent = '';
            }
        }, 1000);

        resendButton.addEventListener('click', function() {
            fetch('{{ route("2fa.resend") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                timeLeft = 60;
                resendButton.disabled = true;
                countdown;
            });
        });
    </script>
</x-guest-layout>