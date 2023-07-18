@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.navbar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                @include('layouts.flash')
                <div class="col-md-12 mb-5">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.orders') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="start"><small class="text-dark">Start
                                                Date{!! required_mark() !!}</small></label>
                                        <input value="{{ request()->startDate ?? '' }}" type="datetime-local"
                                            name="startDate" id="start" class="form-control" placeholder="Start Date">


                                        @error('start')
                                            <span class="text-danger"><small class="text-xs">{{ $message }}</small></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end"><small class="text-dark">End
                                                Date{!! required_mark() !!}</small></label>
                                        <input value="{{ request()->endDate ?? '' }}" type="datetime-local" name="endDate"
                                            id="end" class="form-control" placeholder="End Date">
                                        @error('end')
                                            <span class="text-danger"><small class="text-xs">{{ $message }}</small></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <button type="submit" class="btn btn-success pull-right ml-5">Filter</button>
                                        <button type="reset" class="btn btn-outline-danger pull-right">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 w-100" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                #Order</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Date</th>
                                            <th
                                                class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="view-modal-div"></div>
            @include('layouts.footer2')
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

            <script>
                $(document).ready(function() {
                    $('#usersTable').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: 'Bfrtip',
                        buttons: [{
                                extend: 'csv',
                                className: 'btn btn-info',
                                text: '<i class="fa fa-file-csv"></i> CSV'
                            },
                            {
                                extend: 'pdf',
                                className: 'btn btn-primary',
                                text: '<i class="fa fa-file-pdf"></i> PDF'
                            }
                        ],
                        ajax: {
                            url: "{{ route('admin.orders') }}",
                            data: function(d) {
                                d.startDate = $('input[name=startDate]').val();
                                d.endDate = $('input[name=endDate]').val();
                            }
                        },
                        columns: [{
                                data: 'order_number',
                                name: 'id'
                            },
                            {
                                data: 'total',
                                name: 'total'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at'
                            },
                            {
                                data: 'status_label',
                                name: 'status'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });
                });

                function viewOrder(id) {
                    showAlert('Are you sure to view this order ?', function() {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('admin.orders.view') }}",
                            data: {
                                'id': id
                            },
                            success: function(response) {
                                $('#view-modal-div').html(response);
                                $('#view-modal').modal('show');
                            }
                        });
                    });
                }

                function closeModal() {
                    $('#view-modal').modal('toggle');
                }
            </script>
        </div>
    </main>
@endsection
