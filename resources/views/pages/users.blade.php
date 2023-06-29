@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                @include('layouts.flash')
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 w-100" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Name</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Usertype</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                <td class="text-xs text-secondary mb-0">{{ $user->name }}</td>
                                                <td class="text-xs text-secondary mb-0">{{ $user->email }}</td>
                                                <td class="text-xs text-secondary mb-0 text-left"><span
                                                        class="badge badge-sm bg-gradient-success">{{ $user->usertypedata->usertype }}</span>
                                                </td>
                                                <td class="text-xs text-secondary mb-0 text-left"><span
                                                        class="badge badge-sm bg-gradient-{{ (new App\Models\Colors())->getColor($user['status']) }}">{{ App\Models\User::$status[$user['status']] }}</span>
                                                </td>
                                                <td class="text-xs text-secondary mb-0 text-end">
                                                    <i onclick="doEdit({{ $user->id }})"
                                                        class="fa-solid fa-pen-to-square mx-2 text-warning"></i>
                                                    <i onclick="doDelete({{ $user->id }})"
                                                        class="fa-solid fa-trash mx-2 text-danger"></i>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-xs text-danger">No Data Found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-end">
                                <div class="mt-4">
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <form autocomplete="off" action="{{ route('admin.users.add') }}" method="POST" id="user_form">
                        @csrf
                        <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                        <input type="hidden" id="record" name="record"
                            value="{{ old('record') ? old('record') : '' }}">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Add/Edit Users</h5>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="name"><small
                                                            class="text-dark">Name{!! required_mark() !!}</small></label>
                                                    <input value="{{ old('name') }}" type="text" name="name"
                                                        id="name" class="form-control" placeholder="Your Name ..">
                                                    @error('name')
                                                        <span class="text-danger"><small
                                                                class="text-xs">{{ $message }}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <label for="email"><small
                                                            class="text-dark">Email{!! required_mark() !!}</small></label>
                                                    <input autocomplete="false" value="{{ old('email') }}" type="text"
                                                        name="email" id="email" class="readonly form-control"
                                                        placeholder="Email">
                                                    @error('email')
                                                        <span class="text-danger"><small
                                                                class="text-xs">{{ $message }}</small></span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <label for="password"><small class="text-dark">Password (Min 8
                                                            Characters){!! required_mark() !!}</small></label>
                                                    <input autocomplete="false" value="{{ old('password') }}"
                                                        type="password" name="password" id="password" class="form-control"
                                                        placeholder="Password">
                                                    @error('password')
                                                        <span class="text-danger"><small
                                                                class="text-xs">{{ $message }}</small></span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <label for="password_confirmation"><small class="text-dark">Password
                                                            Confirmation{!! required_mark() !!}</small></label>
                                                    <input value="{{ old('password_confirmation') }}" type="password"
                                                        name="password_confirmation" id="password_confirmation"
                                                        class="form-control" placeholder="Confirmation">
                                                    @error('password_confirmation')
                                                        <span class="text-danger"><small
                                                                class="text-xs">{{ $message }}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <label for="usertype"><small>Usertype
                                                            {!! required_mark() !!}</small></label>
                                                    <select class="form-control" name="usertype" id="usertype">
                                                        @foreach ($usertypes as $usertype)
                                                            <option
                                                                {{ old('usertype') == $usertype->id ? 'selected' : '' }}
                                                                value="{{ $usertype->id }}">
                                                                {{ $usertype->usertype }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('usertype')
                                                        <span class="text-danger">
                                                            <small class="text-xs">{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <label for="status"><small>Status
                                                            {!! required_mark() !!}</small></label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option {{ old('status') == 1 ? 'selected' : '' }} value="1">
                                                            Active
                                                        </option>
                                                        <option {{ old('status') == 2 ? 'selected' : '' }} value="2">
                                                            Inactive
                                                        </option>
                                                    </select>
                                                    @error('status')
                                                        <span class="text-danger">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <hr class="my-2">
                                            <div class="row">
                                                <div class="col-md-6"> <input id="submitbtn"
                                                        class="btn text-white bg-success w-100" type="submit" value="Submit">
                                                </div>
                                                <div class="col-md-6 mt-md-0 mt-1"><input class="btn bg-gradient-danger w-100"
                                                        type="button" form="user_form" id="resetbtn" value="Reset">
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @include('layouts.footer2')
        </div>
    </main>

    <script>
        function doEdit(id) {
            showAlert('Are you sure to edit this record ?', function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.users.get.one') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#name').val(response.name);
                        $('#mobile').val(response.mobile);
                        $('#mac').val(response.mac);
                        $('#nic').val(response.nic);
                        $('#email').val(response.email);
                        $('#email').attr('readonly', '');
                        $('#usertype').val(response.usertype);
                        $('#password').val('');
                        $('#password_confirmation').val('');
                        $('#status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {
            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.users.delete.one') }}?id=" + id;
            });
        }

        @if (old('record'))
            $('#record').val({{ old('record') }});
        @endif

        @if (old('isnew'))
            $('#isnew').val({{ old('isnew') }}).trigger('change');
        @endif
    </script>
@endsection
