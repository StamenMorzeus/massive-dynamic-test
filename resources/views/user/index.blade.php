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

                @elseif(Session::has('errors'))
                    <div class="alert alert-danger">
                        {{Session::get('errors')}}
                    </div>
                @endif
                <a class="btn btn-primary float-end" href="{{ route('user_create') }}" role="button">Create a User</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->value }}</td>
                                <td>
                                    <div class="flex justify-center	items-center">

                                        <a class="" href="{{ route('user_edit', $user->id) }}" role="button"><i class="fa-solid fa-pen-to-square"></i></a>

                                        @if(granted_access([\App\Enums\UserRoleEnum::ADMINISTRATOR->value]))
                                            <form method="post" action="{{route('user_destroy', $user->id)}}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn deleteUser"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links() }}

            </div>
        </div>
    </div>
</x-app-layout>
