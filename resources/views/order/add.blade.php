@extends('layouts.app')

@section('add')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add order') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @error('description')
                        <h6 class="alert alert-danger">{{ $message }}</h6>
                    @enderror

                    @error('amount')
                        <h6 class="alert alert-danger">{{ $message }}</h6>
                    @enderror

                    @error('value')
                        <h6 class="alert alert-danger">{{ $message }}</h6>
                    @enderror

                    @error('type')
                        <h6 class="alert alert-danger">{{ $message }}</h6>
                    @enderror

                    <form action="{{ route('save') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Amount</span>
                            <input type="number" class="form-control" name="amount">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="value">
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="type">Type</label>
                            <select name="type" class="form-select">
                                <option value="" selected>Choose...</option>
                                <option value="Informatica">Informatica</option>
                                <option value="Higiene">Higiene</option>
                                <option value="Administracion">Administracion</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
