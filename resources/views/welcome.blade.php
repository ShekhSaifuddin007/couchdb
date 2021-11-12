<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <div class="my-5 text-center">
                <h3>All Users</h3>
            </div>

            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#userModal">
                            Create
                        </button>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 20%">Name</th>
                                <th style="width: 20%">Email</th>
                                <th style="width: 20%">Phone</th>
                                <th style="width: 20%">Address</th>
                                <th style="width: 20%">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['phone'] }}</td>
                                    <td>
                                        {{
                                            $user['address']['street'].', '.
                                            $user['address']['city'].', '.
                                            $user['address']['district'].', '.
                                            $user['address']['zip']
                                        }}
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary show"

                                            data-rev="{{ $user['rev'] }}"
                                            data-id="{{ $user['id'] }}"
                                            data-name="{{ $user['name'] }}"
                                            data-email="{{ $user['email'] }}"
                                            data-phone="{{ $user['phone'] }}"
                                            data-street="{{ $user['address']['street'] }}"
                                            data-city="{{ $user['address']['city'] }}"
                                            data-district="{{ $user['address']['district'] }}"
                                            data-zip="{{ $user['address']['zip'] }}"
                                        >
                                            Edit
                                        </button>
                                        <a href="{{ route('users.destroy', ['id' => $user['id'], '_rev' => $user['rev']]) }}" class="btn btn-sm btn-danger">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('users.store') }}" method="post" id="userForm">
                        @csrf
                        <div class="modal-body">

                            <input type="hidden" name="_rev" id="rev">
                            <input type="hidden" name="_id" id="docid">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Yuor full name">
                                <x-input-error for="name"/>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter a email">
                                <x-input-error for="email"/>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Yuor mobile number">
                                <x-input-error for="phone"/>
                            </div>

                            <hr/>

                            <div class="text-center">
                               <h4>Address</h4>
                            </div>

                            <div class="mb-3">
                                <label for="address_street" class="form-label">Street</label>
                                <input type="text" class="form-control" id="address_street" name="address_street" placeholder="Your street">
                                <x-input-error for="address_street"/>
                            </div>

                            <div class="mb-3">
                                <label for="address_city" class="form-label">City</label>
                                <input type="text" class="form-control" id="address_city" name="address_city" placeholder="Yuor city">
                                <x-input-error for="address_city"/>
                            </div>

                            <div class="mb-3">
                                <label for="address_district" class="form-label">District</label>
                                <input type="text" class="form-control" id="address_district" name="address_district" placeholder="Yuor district">
                                <x-input-error for="address_district"/>
                            </div>

                            <div class="mb-3">
                                <label for="address_zip" class="form-label">Zip</label>
                                <input type="text" class="form-control" id="address_zip" name="address_zip" placeholder="zip code">
                                <x-input-error for="address_zip"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            var userModal = new bootstrap.Modal(document.querySelector('#userModal'))

            let elements = document.querySelectorAll('.show');

            elements.forEach((show) => {
                show.addEventListener('click', (e) => {
                    e.preventDefault();

                    document.querySelector('#userModalLabel').textContent = 'Update User'

                    let url = document.querySelector('#userForm').action = "{{ route('users.update') }}"

                    console.log(url)

                    document.querySelector('#rev').value = e.target.dataset.rev;
                    document.querySelector('#docid').value = e.target.dataset.id;
                    document.querySelector('#name').value = e.target.dataset.name;
                    document.querySelector('#email').value = e.target.dataset.email;
                    document.querySelector('#phone').value = e.target.dataset.phone;
                    document.querySelector('#address_street').value = e.target.dataset.street;
                    document.querySelector('#address_city').value = e.target.dataset.city;
                    document.querySelector('#address_district').value = e.target.dataset.district;
                    document.querySelector('#address_zip').value = e.target.dataset.zip;

                    userModal.show();
                })
            });

            document.querySelector('#userModal').addEventListener('hidden.bs.modal', () => {
                document.querySelector('#rev').value = '';
                document.querySelector('#docid').value = '';
                document.querySelector('#name').value = '';
                document.querySelector('#email').value = '';
                document.querySelector('#phone').value = '';
                document.querySelector('#address_street').value = '';
                document.querySelector('#address_city').value = '';
                document.querySelector('#address_district').value = '';
                document.querySelector('#address_zip').value = '';

                document.querySelector('#userModalLabel').textContent = 'Create User'
            })
        </script>
    </body>
</html>
