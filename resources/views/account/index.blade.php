@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <span><h2><i class="fas fa-user"></i> Account</h2></span>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backDropModal">
                <i class="fas fa-plus-circle"></i> Add
            </button>
        </div>
        <div class="card-body">
            <table id="table" class="table table-hover data-table">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- add Modal --}}
      @include('account.addModal')
@endsection

@section('script')
    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('account.index') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'level', name: 'level'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $('#nameBackdrop').keyup(function () {
                $('#emails').removeClass('d-none'); 
                $('#emailBackdrop').val($(this).val());
                $('#emailBackdrop').on('propertychange input',function () {
                    $(this).val() = $(this).val().replace(/\s/g, ""); 
                });
            });
            
        });
    </script>
@endsection