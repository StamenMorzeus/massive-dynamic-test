<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">

                <form method="POST" action="{{ route('client_store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" name="id" class="@error('id') is-invalid @enderror form-control" id="id">

                        @error('id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="@error('name') is-invalid @enderror form-control" id="name" required>

                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="@error('address') is-invalid @enderror form-control" id="address" required>

                        @error('username')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="@error('email') is-invalid @enderror form-control" id="email" required>

                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contactPersons" class="form-label">Contact Persons</label>
                        <select class="form-select" id="contactPersons" name="contactPersons[]" multiple="multiple"></select>

                        @error('contactPersons')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary bg-primary float-end">Submit</button>
                </form>

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
