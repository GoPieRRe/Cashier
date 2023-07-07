@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <span><h2><i class="fas fa-list"></i> Menu</h2></span>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenu">
                <i class="fas fa-plus-circle"></i> Add
            </button>
        </div>
        <div class="card-body">
            <table id="table" class="table table-hover data-table">
                <thead>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- add Modal --}}
        {{-- @include('menu.editModal') --}}
        @include('menu.addModal')
@endsection

@section('script')
    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('menu.index') }}",
                columns: [
                    {data: 'image', name: 'image'},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'discount', name: 'discount'},
                    {data: 'total_price', name: 'total_price'},
                    {data: 'type', name: 'type'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });


            function calculateDiscount(price, discountPercentage) {
                var discountAmount = price * (discountPercentage / 100);
                var discountedPrice = price - discountAmount;
                return discountedPrice;
            }

            $('#price').keyup(function () {
                var value = $(this).val();

                if (value == '') {
                    $('#form-discount').addClass('d-none');
                    $('#total').addClass('d-none');
                }else{
                    $('#form-discount').removeClass('d-none');
                }
            });

            $('#inputDiscount').keyup(function () {
                var value = parseInt($(this).val());
        
                if (value > 100) {
                    $(this).val(100);
                }

                var price = $('#price').val();
                var total = calculateDiscount(price, value);
                $('#total-price').val(total);

                if (value == '' || null) {
                    $('#total-price').val('');
                }

            });

            $('#discount').change(function () {
               var value = $(this).val();
               
               if (value == 'yes') {
                    $('#inputDiscount').removeClass('d-none');
                    $('#total').removeClass('d-none');
                    $('#inputDiscount').val('');
                }else{
                    $('#total').addClass('d-none');
                    $('#inputDiscount').val(0);
                    $('#inputDiscount').addClass('d-none');
               }
            });

            $('#imageInput').change(function() {
                var input = this;
                $('#imgs').removeClass('d-none');

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            });

            $('#imageInput').change(function() {
                var input = this;

                if (input.files && input.files[0]) {
                    var formData = new FormData();
                    formData.append('image', input.files[0]);

                    console.log(formData);
                    $.ajax({
                        url: "{{ route('menu.upload') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Handle the response after the image is uploaded
                            console.log(response);
                        },
                        error: function(error) {
                            // Handle any errors during the upload
                            console.error(error);
                        }
                    });
                }
            });
            
        });

    </script>
@endsection