<x-app-layout>
    <x-slot name="title">Profile</x-slot>
    <x-slot name="subtitle">Manage your account information and security settings.</x-slot>

    <div class="space-y-6">
        <x-ui.card>
            @include('profile.partials.update-profile-information-form')
        </x-ui.card>

        <x-ui.card>
            @include('profile.partials.update-password-form')
        </x-ui.card>

        <x-ui.card>
            @include('profile.partials.delete-user-form')
        </x-ui.card>
    </div>
</x-app-layout>
