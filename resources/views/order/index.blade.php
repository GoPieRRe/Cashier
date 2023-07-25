@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <span><h2><i class="fas fa-utensils"></i> Order</h2></span>
        <div class="float-end">
            <a href="{{ route('order.buy') }}" class="btn btn-success"><i class="fas fa-cart-plus"></i> Add Order</a>
        </div>
    </div>
    <div class="card-body">
        <div class="col">
            <div class="nav-align-top mb-4">
              <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-home" aria-controls="navs-justified-home" aria-selected="true">
                    <i class="fa-solid fa-utensils"></i> Ordered
                    @if(count($order->where('status', 'order')) > 0) <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger">{{ count($order->where('status', 'order')) }}</span> @endif
                  </button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile" aria-selected="false">
                    <i class="fa-solid fa-spinner"></i> in the process
                    @if(count($order->where('status', 'proses')) > 0) <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-warning">{{ count($order->where('status', 'proses')) }}</span> @endif
                  </button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages" aria-selected="false">
                    <i class="fa-solid fa-flag-checkered"></i> Finish
                    @if(count($order->where('status', 'finish')) > 0) <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-success">{{ count($order->where('status', 'finish')) }}</span> @endif
                  </button>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                  <div class="list-group">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($check as $item)
                    @if ($item['status'] == 'order')
                    <button class="list-group-item list-group-item-action mt-2 flex-column align-items-start" data-bs-toggle="collapse" href="#collapseExample{{ $item['id'] }}" role="button" aria-expanded="true" aria-controls="collapseExample">
                      <div class="d-flex justify-content-between w-100">
                        <h6>{{ $item['data']['costumer'] }}</h6>
                        <small>{{ $item['created_at'] }}</small>
                      </div>
                      <p class="mb-1">
                        Total: Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                      </p>
                      <small class="p-2">{{ $item['count'] + 1 }} Pesanan</small>
                    </button>
                    <div class="collapse" id="collapseExample{{ $item['id'] }}" style="">
                      <div class="d-grid d-sm-flex p-3 border">
                        <span>
                          <p><img src="{{ asset('image/order.svg') }}" alt="collapse-image" height="30" class="mb-sm-0 mb-2">ID Pesanan: {{ $item['id_costumer'] }}</p>
                          <table class="table w-100 table-bordered mb-2">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Name Product</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Total Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i <= $item['count']; $i++)
                              <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['data'][$i]['product_name'] }}</td>
                                <td>Rp {{ number_format($item['data'][$i]['price'], 0, ',', '.') }},-</td>
                                <td>{{ $item['data'][$i]['discount'] }} %</td>
                                <td>Rp {{ number_format($item['data'][$i]['total_price_product'], 0, ',', '.') }},-</td>
                                <td>{{ $item['data'][$i]['quantity'] }}</td>
                                <td>Rp {{ number_format($item['data'][$i]['sub_total'], 0, ',', '.') }},-</td>
                              </tr>
                              @endfor
                              <tr>
                                <td colspan="6" align="center">Total</td>
                                <td align="center">Rp {{ number_format($item['total_price'], 0, ',', '.') }},-</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="float-end">
                            <a href="order/{{ $item['id'] }}/updateStatus" type="submit" class="btn btn-lg btn-warning">proses</a>
                          </div>
                        </span>
                      </div>
                    </div>
                    @php
                        $i++;
                    @endphp
                    @endif
                    @endforeach 
                  </div>
                </div>
                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                  <div class="list-group">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($check as $item)
                    @if ($item['status'] == 'proses')
                    <button class="list-group-item list-group-item-action mt-2 flex-column align-items-start" data-bs-toggle="collapse" href="#collapseExample{{ $item['id'] }}" role="button" aria-expanded="true" aria-controls="collapseExample">
                      <div class="d-flex justify-content-between w-100">
                        <h6>{{ $item['data']['costumer'] }}</h6>
                        <small>{{ $item['updated_at'] }}</small>
                      </div>
                      <p class="mb-1">
                        Total: Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                      </p>
                      <small class="p-2">{{ $item['count'] + 1 }} Pesanan</small>
                    </button>
                    <div class="collapse" id="collapseExample{{ $item['id'] }}" style="">
                      <div class="d-grid d-sm-flex p-3 border">
                        <span>
                          <p><img src="{{ asset('image/order.svg') }}" alt="collapse-image" height="30" class="mb-sm-0 mb-2">ID Pesanan: {{ $item['id_costumer'] }}</p>
                          <table class="table w-100 table-bordered mb-2">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Name Product</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Total Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i <= $item['count']; $i++)
                              <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['data'][$i]['product_name'] }}</td>
                                <td>Rp {{ number_format($item['data'][$i]['price'], 0, ',', '.') }},-</td>
                                <td>{{ $item['data'][$i]['discount'] }} %</td>
                                <td>Rp {{ number_format($item['data'][$i]['total_price_product'], 0, ',', '.') }},-</td>
                                <td>{{ $item['data'][$i]['quantity'] }}</td>
                                <td>Rp {{ number_format($item['data'][$i]['sub_total'], 0, ',', '.') }},-</td>
                              </tr>
                              @endfor
                              <tr>
                                <td colspan="6" align="center">Total</td>
                                <td align="center">Rp {{ number_format($item['total_price'], 0, ',', '.') }},-</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="float-end">
                            <button type="submit" data-id="{{ $item['id'] }}" data-name="{{ $item['data']['costumer'] }}" class="btn btn-finish btn-lg btn-success">Done</button>
                          </div>
                        </span>
                      </div>
                    </div>
                    @php
                        $i++;
                    @endphp
                    @endif
                    @endforeach 
                  </div>
                </div>
                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                  <div class="list-group">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($check as $item)
                    @if ($item['status'] == 'finish')
                    <button class="list-group-item list-group-item-action mt-2 flex-column align-items-start" data-bs-toggle="collapse" href="#collapseExample{{ $item['id'] }}" role="button" aria-expanded="true" aria-controls="collapseExample">
                      <div class="d-flex justify-content-between w-100">
                        <h6>{{ $item['data']['costumer'] }}</h6>
                        <small>{{ $item['updated_at'] }}</small>
                      </div>
                      <p class="mb-1">
                        Total: Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                      </p>
                      <small class="p-2">{{ $item['count'] + 1 }} Pesanan</small>
                    </button>
                    <div class="collapse" id="collapseExample{{ $item['id'] }}" style="">
                      <div class="d-grid d-sm-flex p-3 border">
                        <span>
                          <p><img src="{{ asset('image/order.svg') }}" alt="collapse-image" height="30" class="mb-sm-0 mb-2">ID Pesanan: {{ $item['id_costumer'] }}</p>
                          <table class="table w-100 table-bordered mb-2">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Name Product</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Total Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody>
                            @for ($i = 0; $i <= $item['count']; $i++)
                              <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['data'][$i]['product_name'] }}</td>
                                <td>Rp {{ number_format($item['data'][$i]['price'], 0, ',', '.') }},-</td>
                                <td>{{ $item['data'][$i]['discount'] }} %</td>
                                <td>Rp {{ number_format($item['data'][$i]['total_price_product'], 0, ',', '.') }},-</td>
                                <td>{{ $item['data'][$i]['quantity'] }}</td>
                                <td>Rp {{ number_format($item['data'][$i]['sub_total'], 0, ',', '.') }},-</td>
                              </tr>
                              @endfor
                              <tr>
                                <td colspan="6" align="center">Total</td>
                                <td align="center">Rp {{ number_format($item['total_price'], 0, ',', '.') }},-</td>
                              </tr>
                            </tbody>
                          </table>
                        </span>
                      </div>
                    </div>
                    @php
                        $i++;
                    @endphp
                    @endif
                    @endforeach 
                  </div>
                </div>
              </div>
          </div>
      </div>
@endsection

@section('script')
@if (session('back'))
    <script>
      window.location.reload();
    </script>
@endif
    <script>
      $(function () {
        $('.btn-finish').click(function () {
          let id = $(this).data('id');
          let name = $(this).data('name');
          Swal.fire({
            title: 'Pesanan '+name+' Sudah siapp?',
            text: "Pesanan akan segera dikirim!",
            icon: 'warning',
            showCancelButton: true,
            backdrop: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sudah!',
            cancelButtonText: 'Belum'
        }).then((result) => {
            if (result.isConfirmed) {
                // The user clicked the "Confirm" button
                // Put your action here that should be performed after confirmation
                $.ajax({
                  url: '/order/'+id+'/updateStatus',
                  success: function () {
                    Swal.fire({
                      title: 'Pesanan '+name+' Sudah siap!',
                      text: "Pesanan akan segera dikirim.",
                      icon: 'success',
                      backdrop: false,
                      confirmButtonColor: '#3085d6',
                      confirmButtonText: 'Ok!',
                    }).then((result) => {
                      if (result.isConfirmed) { 
                        location.reload();
                      }
                    });
                  }
                });
            } else {
                // The user clicked the "Cancel" button or clicked outside the popup
                Swal.fire({
                  title: 'Pesanan '+name+' belum siap!',
                  text: "Tunggu sebentar lagi.",
                  icon: 'error',
                  backdrop: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Ok!',
                });
            }
        });
        });
      });
    </script>
@endsection