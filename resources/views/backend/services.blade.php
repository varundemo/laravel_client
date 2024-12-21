@extends('layouts.backend') 

@section('content')

<!-- HTML Table -->
<table class="table table-striped custom-table datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Service Name</th>
            <th>Service Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($services as $key => $service)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $service->name }}</td>
                <td class="price-cell" data-id="{{ $service->id }}">
                    <span class="price-value">{{ $service->price }}</span>
                    <input type="number" class="form-control price-input" value="{{ $service->price }}" style="display: none;">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Buttons -->
<button class="btn btn-primary convert-btn">Convert to Input</button>
<button class="btn btn-success update-all-btn" style="display: none;">Update All</button>


@endsection


@section('scripts')

<script>
     $(document).ready(function() {
        // Click event on convert button
        $('.convert-btn').click(function() {
            // Convert all price cells to input fields
            $('.price-cell').each(function() {
                var cell = $(this);
                var priceValue = cell.find('.price-value').text();

                cell.find('.price-value').hide();
                cell.find('.price-input').show().val(priceValue);
            });

            // Toggle visibility of convert and update all buttons
            $('.convert-btn').hide();
            $('.update-all-btn').show();
        });

        // Click event on update all button
        $('.update-all-btn').click(function() {
            // Prepare an array to store updated prices
            var updatedPrices = [];

            // Iterate through each price input
            $('.price-input').each(function() {
                var cell = $(this).closest('.price-cell');
                var serviceId = cell.data('id');
                var price = $(this).val();

                // Create an object with service ID and updated price
                var updatedPrice = {
                    id: serviceId,
                    price: price
                };

                // Push the object to the array
                updatedPrices.push(updatedPrice);
            });

            // Send an AJAX request to update the prices
            $.ajax({
                method: 'POST',
                url: '/update-prices',
                data: {
                    prices: updatedPrices
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Refresh the table to display updated values
                    location.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
    
@endsection