@extends('layouts.app')

@section('error2')
    <div class="container w-50 mt-4">
        
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
    </div>
@endsection

@section('show')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit order') }}</div>

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

                    <form action="{{ route('show', ['id' => $order->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text">Description</span>
                            <textarea class="form-control" name="description">{{ $order->description }}</textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Amount</span>
                            <input type="number" class="form-control" name="amount" value="{{ $order->amount }}">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="value" value="{{ $order->value }}">
                            <span class="input-group-text">.00</span>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="type">Type</label>
                            <select name="type" class="form-select">
                                @switch($order->type)
                                    @case('Informatica')
                                        <option value="Informatica" selected>Informatica</option>
                                        <option value="Higiene">Higiene</option>
                                        <option value="Administracion">Administracion</option>
                                    @break
                                    @case('Higiene')
                                        <option value="Informatica">Informatica</option>
                                        <option value="Higiene" selected>Higiene</option>
                                        <option value="Administracion">Administracion</option>
                                    @break
                                    @case('Administracion')
                                        <option value="Informatica">Informatica</option>
                                        <option value="Higiene">Higiene</option>
                                        <option value="Administracion" selected>Administracion</option>
                                    @break
                                @endswitch
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
