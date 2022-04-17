<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('User Information') }}
                </h3>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" value="{{ $user->username }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                </div>
            </div>

            @if($user->role === \App\Enums\UserRoleEnum::CLIENT && !empty($user->client))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Client Information') }}
                    </h3>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $user->client->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Username</label>
                        <input type="text" name="address" class="form-control" id="address" value="{{ $user->client->address }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email" value="{{ $user->client->email }}" readonly>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
