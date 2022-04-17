<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="row">
                    <div class="col bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 mr-2">

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('client_update', $client->id) }}" enctype="multipart/form-data">
                            @method("PUT")
                            @csrf

                            <div class="mb-3">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" name="id" class="form-control" id="id" value="{{ $client->id }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" id="name" value="{{ $client->name }}" required>

                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="@error('address') is-invalid @enderror form-control" id="address" value="{{ $client->address }}" required>

                                @error('username')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" value="{{ $client->email }}" readonly>

                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contactPersons" class="form-label">Contact Persons</label>
                                <select class="form-select" id="contactPersons" name="contactPersons[]" multiple="multiple">
                                    @foreach($client->contactPersons as $contactPerson)
                                        <option value="{{ $contactPerson->id }}" selected="selected">{{ $contactPerson->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="documents" class="form-label">Contact Persons</label>
                                <input class="form-select" type="file" name="documents[]" placeholder="Choose files" multiple>
                                @error('documents')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary bg-primary float-end">Submit</button>
                        </form>

                    </div>

                    <div class="col bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 ml-2">
                        <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Client Documents') }}
                        </h3>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($client->documents as $document)
                                <tr>
                                    <td>{{ $document->name }}</td>
                                    <td class="flex justify-center	items-center">
                                        <a class="" href="{{ route('download_document', $document->id) }}" role="button"><i class="fa-solid fa-download"></i></a>

                                        @if(granted_access([\App\Enums\UserRoleEnum::ADMINISTRATOR->value]))

                                            <form method="post" action="{{route('delete_document', $document->id)}}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn deleteDocument"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    var path = "{{ route('clients_search') }}";

    $('#contactPersons').select2({
        placeholder: 'Select users',
        ajax: {
            url: path,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
