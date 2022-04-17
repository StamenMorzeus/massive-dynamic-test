<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">

                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif

                <form method="POST" action="{{ route('user_update', $user->id) }}">
                    @method("PUT")
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" id="name" value="{{ $user->name }}" required>

                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="@error('username') is-invalid @enderror form-control" id="username" value="{{ $user->username }}" required>

                        @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" value="{{ $user->email }}" readonly>

                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="@error('role') is-invalid @enderror form-select" name="role" id="role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" @if($role === $user->role->value) selected @endif>{{ $role }}</option>
                            @endforeach
                        </select>

                        @error('role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary bg-primary float-end">Submit</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
