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
                                    <div class="col-md-6">
                                        <label for="start"><small class="text-dark">Start
                                                Date{!! required_mark() !!}</small></label>
                                        <input value="{{ request()->start ?? '' }}" type="datetime-local" name="start"
                                            id="start" class="form-control" placeholder="Start Date">
                                        @error('start')
                                            <span class="text-danger"><small class="text-xs">{{ $message }}</small></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end"><small class="text-dark">End
                                                Date{!! required_mark() !!}</small></label>
                                        <input value="{{ request()->end ?? '' }}" type="datetime-local" name="end"
                                            id="end" class="form-control" placeholder="End Date">
                                        @error('end')
                                            <span class="text-danger"><small class="text-xs">{{ $message }}</small></span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <center>
                                            <button type="reset"
                                                class="btn btn-outline-danger pull-right mr-5">Clear</button>
                                            <button type="submit" class="btn btn-success pull-right ml-5">Filter</button>
                                        </center>
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
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td class="text-xs text-secondary mb-0">
                                                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                                <td class="text-xs text-secondary mb-0">
                                                    {{ format_currency($order->total) }}</td>
                                                <td class="text-xs text-secondary mb-0">{{ $order->created_at }}</td>
                                                <td class="text-xs text-secondary mb-0 text-left"><span
                                                        class="badge badge-sm bg-gradient-{{ (new App\Models\Colors())->getColor($order['status']) }}">{{ App\Models\Cart::$status[$order['status']] }}</span>
                                                </td>
                                                <td class="text-xs text-secondary mb-0 text-end">
                                                    <button onclick="viewOrder({{ $order->id }})"
                                                        class="btn btn-sm btn-info">View</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-xs text-danger">No Data Found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-end">
                                <div class="mt-4">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="view-modal-div"></div>
            @include('layouts.footer2')

            <script>
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
