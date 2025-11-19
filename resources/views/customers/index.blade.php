@extends('adminlte::page')

@section('title', 'Customers')
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
        <h3 class="card-title">Customer List</h3>

        <a href="{{ route('customers.create') }}" 
           class="btn btn-success btn-sm ml-auto">
            <i class="fas fa-plus"></i> Add New Customer
        </a>
    </div>

    <div class="card-body">

        <table id="customersTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Parent</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($customers as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone }}</td>

                    <td>
                        @if($c->parent)
                            {{ $c->parent->name }}
                        @else 
                            —
                        @endif
                    </td>

                    <td>{{ $c->created_at }}</td>

                    <td>
                        <a href="{{ route('customers.edit', $c->id) }}" 
                        class="btn btn-info btn-sm" 
                        title="Edit Customer">
                            <i class="fas fa-edit"></i> 
                        </a>

                        <form action="{{ route('customers.destroy', $c->id) }}" 
                            method="POST" 
                            style="display: inline;" 
                            onsubmit="return confirm('Are you sure you want to delete this customer?');">
                            
                            @csrf {{-- CSRF protection token --}}
                            @method('DELETE') {{-- Spoof the DELETE HTTP method --}}

                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Customer">
                                <i class="fas fa-trash"></i> {{-- DELETE ICON --}}
                            </button>
                        </form>
                    </td>
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
