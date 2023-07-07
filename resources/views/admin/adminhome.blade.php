@extends('layouts.main')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">
                <span class="text-bold p-2">Admin</span>
            </div>
            <div class="card-body">
                <span class="text-center">
                    <h1>Welcome {{ auth()->user()->name }}</h1>
                    <div class="p-6 m-2 bg-white rounded shadow">
                        {!! $chart->container() !!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
@endsection