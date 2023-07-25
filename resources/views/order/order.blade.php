@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
          <span><h2><i class="fas fa-cart-shopping"></i> Order</h2></span>
        <div class="float-end">
          <a href="{{ route('order.checkout') }}" class="btn btn-warning"><i class="fas fa-cart-plus"></i> CheckOut</a>
        </div>
    </div>
    <div class="card-body">
      <div class="row">
        @foreach ($menu as $m)
            <form action="{{ route('cart.add') }}" class="col-sm-4 col-8 mb-3" method="post">
              @csrf
              <input type="hidden" name="id" value="{{ $m->id }}">
                <div class="card">
                  <img class="card-img-top" height="200px" width="100%" src="{{ asset('storage/images/menu') }}/{{ $m->image }}" alt="{{ $m->name }}">
                  <div class="card-body">
                    <h5 class="card-title">{{ $m->name }}</h5>
                    <p class="card-text">
                      @if ($m->discount > 0) <s>Rp {{ number_format($m->price, 0, ',','.') . ',-' }}</s><b class="text-danger text-end"> {{ $m->discount }}%</b> @endif
                      <br>
                      Rp {{ number_format($m->total_price, 0, ',','.') . ',-' }}
                    </p>
                      <div class="text-end">  
                        <div class="col-12 mb-2">
                          <div class="input-group justify-content-end">
                            <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                            <input type="number" step="1" readonly max="10" value="0" name="quantity" class="quantity-field border-0 text-center w-25">
                            <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity">
                          </div>
                        </div>
                          <button type="submit" class="btn btn-sm btn-outline-success"><i class="fas fa-cart-plus"></i> Add to chart</button>
                      </div>
                  </div>
              </div>
            </form>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>
      $(function () {
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
      });
    </script>
@endsection