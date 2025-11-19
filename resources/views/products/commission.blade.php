@extends('adminlte::page')

@section('title', 'Commission')

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
        <h3 class="card-title">Commission - {{$salesData->customer->name}} - {{$salesData->product->name}} - {{$salesData->product->price}} </h3>
    </div>

       <div class="card mt-3">
            <div class="card-header bg-success text-white">
            <h3 class="card-title">Commission Breakdown</h3>
            </div>


            <div class="card-body table-responsive p-0">
            <table class="table table-bordered text-nowrap">
            <thead class="bg-light">
            <tr>
            <th style="width: 80px">Level</th>
            <th>User</th>
            <th>Email</th>
            <th style="width: 120px">%</th>
            <th style="width: 150px">Commission</th>
            </tr>
            </thead>


            <tbody>
            @foreach($levels as $row)
            <tr>
            <td>Level {{ $row['level'] }}</td>
            <td>{{ $row['user'] ?? 'N/A' }}</td>
            <td>{{ $row['email'] ?? '-' }}</td>
            <td>{{ $row['rate'] }}%</td>
            <td>₹{{ number_format($row['amount']) }}</td>
            </tr>
            @endforeach
            </tbody>
            </table>
            </div>
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
