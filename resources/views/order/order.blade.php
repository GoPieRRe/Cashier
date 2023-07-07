@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
          <span><h2><i class="fas fa-user"></i>Hello, {{ auth()->user()->name }}</h2></span>
        <div class="float-end">
          <button class="btn btn-warning"><i class="fas fa-cart-plus"></i> CheckOut</button>
        </div>
    </div>
    <div class="card-body">
            
    </div>
</div>
@endsection