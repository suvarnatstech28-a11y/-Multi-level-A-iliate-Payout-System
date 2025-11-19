@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    <h1>Customers</h1><br>

    @if (session('success'))
        {{-- Checks if a session message exists with the key 'success' --}}
        
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            
            {{-- Retrieves and displays the message content --}}
            {{ session('success') }}
            
            {{-- Optional: Bootstrap close button --}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@stop


@section('content')

{{-- ========================= --}}
{{--     DATATABLE SECTION     --}}
{{-- ========================= --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Products List</h3>
    </div>

    <div class="card-body">

        <table id="customersTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->name }}</td>
                    <td> <a href="{{  route('products.store', $c->id) }}" 
                    class="btn btn-success btn-sm ml-auto">
                        <i class="fas fa fa-shopping-cart"></i> Purchase
                    </a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop


@section('js')
<script>
    $(function () {
        $('#customersTable').DataTable();
    });
</script>
@stop
@section('css')
    {{-- Add extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
