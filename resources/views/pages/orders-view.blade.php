<div class="modal modal-lg fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="view-modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="view-modalLabel">Order Details</h5>
            </div>
            <div class="modal-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $record)
                            <tr>
                                <td>{{ $record->productdata->name ?? '' }}</td>
                                <td>{{ $record->qty ?? '' }}</td>
                                <td>{{ format_currency($record->total ?? 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>
