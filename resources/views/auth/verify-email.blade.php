<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Vă mulțumim pentru înscriere! Înainte de a începe, ați putea să vă verificați adresa de e-mail făcând clic pe linkul pe care tocmai vi l-am trimis prin e-mail? Dacă nu ați primit e-mailul, vă vom trimite cu plăcere un altul.') }}
    </div>
<div class="mb-4 text-sm text-gray-600">
    Dacă ai probleme cu linkul de mai jos, contactează echipa de suport.
</div>
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
