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
                                                Usertype</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Permitted Routes</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usertypes as $usertype)
                                            <tr>
                                                <td class="text-xs text-secondary mb-0">{{ $usertype->usertype }}</td>

                                                @php
                                                    $cellData = '';
                                                    foreach ($usertype->permissionandroutesdata as $key => $value) {
                                                        $cellData .= '<small class="text-success">' . $value['routedata']->name . '</small><br>';
                                                    }
                                                @endphp

                                                <td class="text-xs text-secondary mb-0">{!! $cellData !!}</td>
                                                <td class="text-xs text-secondary mb-0 text-left"><span
                                                        class="badge badge-sm bg-gradient-{{ (new App\Models\Colors())->getColor($usertype['status']) }}">{{ App\Models\User::$status[$usertype['status']] }}</span>
                                                </td>
                                                <td class="text-xs text-secondary mb-0 text-end">
                                                    <i onclick="doEdit({{ $usertype->id }})"
                                                        class="fa-solid fa-pen-to-square mx-2 text-warning"></i>
                                                    <i onclick="doDelete({{ $usertype->id }})"
                                                        class="fa-solid fa-trash mx-2 text-danger"></i>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-xs text-danger">No Data Found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-end">
                                <div class="mt-4">
                                    {{ $usertypes->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('admin.usertypes.add') }}" method="POST" id="usertype_form">
                        @csrf
                        <input type="hidden" id="isnew" name="isnew" value="{{ old('isnew') ? old('isnew') : '1' }}">
                        <input type="hidden" id="record" name="record"
                            value="{{ old('record') ? old('record') : '' }}">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Add/Edit Usertype</h5>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="usertype"><small class="text-dark">Usertype
                                                    {!! required_mark() !!}</small></label>
                                            <input value="{{ old('usertype') }}" type="text" name="usertype"
                                                id="usertype" class="form-control" placeholder="Enter Usertype">
                                            @error('usertype')
                                                <span class="text-danger"><small>{{ $message }}</small></span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <label for="status"><small>Status {!! required_mark() !!}</small></label>
                                            <select class="form-control" name="status" id="status">
                                                <option {{ old('status') == 1 ? 'selected' : '' }} value="1">Active
                                                </option>
                                                <option {{ old('status') == 2 ? 'selected' : '' }} value="2">Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <label for="turnno"><small class="text-dark">Permissions
                                                    {!! required_mark() !!}</small></label>
                                            <br>
                                            <div class="row">

                                                @foreach ($routes as $route)
                                                    <div class="col-md-12 mt-1 ml-2">
                                                        <div class="">
                                                            <label>
                                                                <input value="{{ $route->id }}"
                                                                    class="permissions_checkbox"
                                                                    id="permission{{ $route->id }}" name="permissions[]"
                                                                    type="checkbox">
                                                                <small> {{ $route->name }}</small>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row">
                                            <div class="col-md-6"> <input id="submitbtn"
                                                    class="btn text-white bg-success w-100" type="submit" value="Submit">
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-1"><input class="btn bg-gradient-danger w-100"
                                                    type="button" form="usertype_form" id="resetbtn" value="Reset">
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
                    url: "{{ route('admin.usertypes.get.one') }}",
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#usertype').val(response.usertype);
                        $('.permissions_checkbox').prop('checked', false);
                        response.permissionandroutesdata.forEach(permission => {
                            $('#permission' + permission.route).prop('checked', true);
                        });
                        $('#status').val(response.status);
                        $('#record').val(response.id);
                        $('#isnew').val('2').trigger('change');
                    }
                });
            });
        }

        function doDelete(id) {
            showAlert('Are you sure to delete this record ?', function() {
                window.location = "{{ route('admin.usertypes.delete.one') }}?id=" + id;
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
