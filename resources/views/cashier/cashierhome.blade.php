@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="text-bold">Cashier</span>
        </div>
        <div class="card-body">
            <span class="text-center">
                <h1>Welcome {{ auth()->user()->name }}</h1>
            </span>
        </div>
    </div>
@endsection