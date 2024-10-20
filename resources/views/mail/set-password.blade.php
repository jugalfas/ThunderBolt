<x-mail::message>
    # Welcome to {{ config('app.name') }}!

    We are excited to have you on board. Before you can start using your account, you'll need to set a password. Click
    the button below to set your password and complete your account setup.

    <x-mail::button :url="$url">
        Set Your Password
    </x-mail::button>

    If you didn't create this account, you can ignore this email.

    Thanks,<br>
    The {{ config('app.name') }} Team
</x-mail::message>
