@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('order.buy') }}" class="btn btn-danger">back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('order.store') }}" onsubmit="window.location.reload();" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <label for="costumer">Costumer Name:</label>
                    <input type="text" class="form-control" name="costumer" id="costumer" placeholder="Input costumer name..." required>
                </div>
                @if (count($cartItems) > 0)
                <div class="table-responsive">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                @foreach ($result as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',' , '.') }},-</td>
                            <td>Rp {{ number_format($item['total_price'], 0,',','.') }},- </td>
                            <td>
                                <div class="input-group">
                                    <input type="button" value="-" class="button-minus border rounded-circle icon-shape icon-sm mx-1 " data-product="{{ $item['id'] }}" data-field="quantity">
                                    <input type="number" step="1" readonly max="10" value="{{ $item['quantity'] }}" class="quantity-field border-0 text-center w-25">
                                    <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-product="{{ $item['id'] }}" data-field="quantity">
                                </div>
                            </td>
                        </tr>
            
                    @php
                        $total += $item['total_price'];
                    @endphp

                @endforeach
                        <tr>
                            <td colspan="4"></td>
                            <td>Total</td>
                            <td>Rp {{ number_format($total, 0, ',' ,'.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
                <p>Your cart is empty.</p>
            @endif 
            <div class="text-end mt-3">
                <button type="submit" id="btn-buys" class="btn btn-primary" >Buy <i class="fa-solid fa-coins"></i></button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
    <script>
        $(function () {
            $('#btn-buys').on('click', function () {
                $.ajax({
                    url: '{{ route("order.invoice") }}',
                    success: function () {
                        setTimeout(function() {
                        window.location.href = '{{ route("order.index") }}';
                        }, 1000);
                    }
                }); 
            });

            $('.button-plus').on('click', function () {
                const productId = $(this).data('product');
                changeCartQuantity(productId, 'increment');
            });

            $('.button-minus').on('click', function () {
                const productId = $(this).data('product');
                changeCartQuantity(productId, 'decrement');
            });

            function changeCartQuantity(productId, action) {
                // Implement an AJAX call to send the request to the server
                // and update the cart quantity in the backend.
                // For simplicity, I'll use a basic jQuery AJAX request here.
                $.ajax({
                    url: `/cart/${action}`,
                    type: 'POST',
                    data: { product_id: productId, _token: '{{ csrf_token() }}' },
                    dataType: 'json',
                    success: function (data) {
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            }

            function incrementValue(e) {
                e.preventDefault();
                var fieldName = $(e.target).data('field');
                var parent = $(e.target).closest('div');
                var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                if (!isNaN(currentVal)) {
                    parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
                } else {
                    parent.find('input[name=' + fieldName + ']').val(0);
                }
            }

                function decrementValue(e) {
                    e.preventDefault();
                    var fieldName = $(e.target).data('field');
                    var parent = $(e.target).closest('div');
                    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

                    if (!isNaN(currentVal) && currentVal > 0) {
                        parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
                    } else {
                        parent.find('input[name=' + fieldName + ']').val(0);
                    }
                }

                $('.input-group').on('click', '.button-plus', function(e) {
                    incrementValue(e);
                });

                $('.input-group').on('click', '.button-minus', function(e) {
                    decrementValue(e);
                });

                $('.btn-buys').on('click',function () {
                    location.reload();
                });
      });
    </script>
@endsection