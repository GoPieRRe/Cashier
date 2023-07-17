@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <span>
                <h2>Edit {{ $data->name }}</h2>
            </span>
        </div>
        <form action="{{ route('menu.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <input type="hidden" id="cancelUpload" value="{{ asset('storage/images/menu') }}/{{ $data->image }}">
                <img src="{{ asset('storage/images/menu') }}/{{ $data->image }}" alt="{{ $data->name }}" class="img-fluid rounded" height="100" width="100" id="uploadMenu">
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input type="file" id="upload" name="uploadNew" class="account-file-input" hidden="" accept="image/*">
                    </label>
                </div>
                <button type="button" id="cancelButton" class="btn btn-outline-secondary account-image-reset mb-4">
                    <i class="bx bx-reset d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Reset</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
            <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">Menu Name</label>
                <input class="form-control" type="text" id="menuName" name="menu_name" value="{{ $data->name }}" autofocus="">
            </div>
            <div class="mb-3 col-md-6">
                <label for="lastName" class="form-label">Price</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">Rp.</span>
                    <input class="form-control number" type="text" min="1" name="price" id="price" value="{{ $data->price }}">
                </div>
            </div>
            {{-- <div class="mb-3 col-md-6">
                <label for="discount" class="form-label">discount</label>
                <input class="form-control"min="0" max="100" type="number" id="discount" name="discount" value="{{ $data->discount }}" placeholder="...%">
            </div> --}}
            <div class="mb-3 col-md-6" id="form-discount">
                <label for="discount" class="form-label">Discount</label>
                <select id="discount" name="optionDiscount" class="form-control">
                    @if($data->discount <1)
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                    @else
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                    @endif
                </select>
                <input type="hidden" id="dsc" value="{{ $data->discount }}">
                <input type="number" placeholder="Discount..." min="0" max="100" name="discount" class="mt-2 form-control d-none" value="{{ $data->discount }}" id="inputDiscount">
            </div>
            <div class="mb-3 col-md-6">
                <label for="organization" class="form-label">Total Price</label>
                <input type="hidden" id="tots" value="{{ $data->total_price }}">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" >Rp.</span>
                    <input type="text" class="form-control" id="total-price" readonly name="total_price" value="{{ $data->total_price }}">
                </div>
            </div>
            <div class="mb-3 col-md-6">
                <label for="Nama" class="form-label">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="{{ $data->type }}">{{ $data->type }}</option>
                    <option value="foods">foods</option>
                    <option value="drinks">drinks</option>
                    <option value="desserts">dessert</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="Nama" class="form-label">Status</label>
                <label class="switch">
                    <input id="switch" type="checkbox" name="status" @if($data->status == true) checked @endif>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</form>
</div>
@endsection


@section('script')
<script>
    $(function () {

        $(window).on('load',function () {
            
            var select = $('#type');

            // Dapatkan semua elemen option dalam select
            var options = select.find('option');

            console.log(options);

            // Objek untuk menyimpan nilai yang telah muncul
            var nilaiMuncul = {};

            // Iterasi melalui semua elemen option
            options.each(function() {
            var nilai = $(this).val(); // Dapatkan nilai option

            // Periksa apakah nilai sudah ada dalam objek nilaiMuncul
            if (nilai in nilaiMuncul) {
                $(this).remove(); // Hapus elemen option yang memiliki nilai ganda
            } else {
                nilaiMuncul[nilai] = true; // Tandai nilai sebagai muncul
            }

                var value = $('#discount').val();
                if (value == "no") {
                    $('#inputDiscount').val("");

                    $('#inputDiscount').val(0);
                    
                    $('#inputDiscount').addClass('d-none');
                    
                }else{
                    $('#inputDiscount').removeClass('d-none');
                }
            });


            function calculateDiscount(price, discountPercentage) {
                var discountAmount = price * (discountPercentage / 100);
                var discountedPrice = price - discountAmount;
                return discountedPrice;
            }

            

        $('#upload').change(function() {
            var input = this;
            $('#uploadMenu').attr('src', "");
            var cn = $('#cancelUpload').val();

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#uploadMenu').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        });

            $('#cancelButton').click(function () {
                var file = $('#cancelUpload').val(); //ambil value cancel upload
                $('#uploadMenu').attr('src', file); //masukkan value
                $('#upload').val(''); // kosongkan value upload
            }); 

            $('#inputDiscount').keyup(function () {
                var value = parseInt($(this).val());
        
                if (value > 100) {
                    $(this).val(100);
                }
                if (value == '') {
                    $(this).val(0);
                }

                var price = parseInt($('#price').val().replace(/\./g, ''));
                var total = calculateDiscount(price, value);
                $('#total-price').val(total);

                if (value == '' || NaN) {
                    $('#total-price').val('');
                }

            });

            $('#price').keyup(function () {
                var price = parseInt($(this).val().replace(/\./g, ''));
                var value = $('#inputDiscount').val();
                var total = calculateDiscount(price, value);
                $('#total-price').val(total);

                if (value == '' || NaN) {
                    $('#total-price').val('');
                }
            });

          
            $('#discount').change(function () {
                var value = $(this).val();
                var price = $('#price').val();
                $('#total-price').val(price);
                if (value == "no") {
                    
                    $('#inputDiscount').addClass('d-none');
                    $('#inputDiscount').addAttr('disabled');
                    
                    
                }else{
                    var disc = $('#dsc').val();
                    $('#inputDiscount').val(disc);
                    $('#inputDiscount').removeClass('d-none');
                }
            });


        });
    });
    </script>
@endsection