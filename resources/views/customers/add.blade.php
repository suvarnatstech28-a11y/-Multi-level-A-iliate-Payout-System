@extends('adminlte::page')

@section('title', 'Customer')

@section('content_header')
    <h1>Customer</h1>
@stop

@section('content')

{{-- ========================= --}}
{{--   CUSTOMER FORM SECTION   --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Add New Customer</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- Name --}}
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value ="{{ old('name') }}" required>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value ="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class= "form-control @error('phone') is-invalid @enderror" value ="{{ old('phone') }}">
                     @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Parent ID (dropdown) --}}
                <div class="col-md-6 mb-3">
                    <label>Parent Customer</label>
                    <select name="parent_id" class="form-control">
    
                    {{-- 1. Default Option: Must check if old('parent_id') is empty or 0 --}}
                    <option value="">
                        -- No Parent --
                    </option>

                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" 
                            {{-- 2. Check the old value against the current option's ID --}}
                            {{ old('parent_id') == $p->id ? 'selected' : '' }}
                        >
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
                </div>

            </div>

            <button class="btn btn-primary mt-2">Submit</button>

        </form>
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
