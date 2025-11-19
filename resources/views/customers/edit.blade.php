@extends('adminlte::page')

@section('title', 'Customer')

@section('content_header')
    <h1>Customer Profile</h1>
@stop

@section('content')

{{-- ========================= --}}
{{--   CUSTOMER FORM SECTION   --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Update Customer</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT') {{-- Required for update route --}}

    <div class="row">

        {{-- Name --}}
        <div class="col-md-6 mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $customer->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="col-md-6 mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $customer->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Phone --}}
        <div class="col-md-6 mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" 
                class="form-control @error('phone') is-invalid @enderror" 
                value="{{ old('phone', $customer->phone) }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Parent ID (dropdown) --}}
        <div class="col-md-6 mb-3">
            <label for="parent_id">Parent Customer</label>
            <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                
                {{-- Default Option --}}
                <option value="" 
                    {{ old('parent_id', $customer->parent_id) == '' ? 'selected' : '' }}>
                    -- No Parent --
                </option>
            
                @foreach($parents as $p)
                    <option value="{{ $p->id }}" 
                        {{ old('parent_id', $customer->parent_id) == $p->id ? 'selected' : '' }}
                    >
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn btn-success mt-2"><i class="fas fa-save"></i> Save Changes</button>

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
