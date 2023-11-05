@extends('layouts.app')

@section('title', 'Edit Promocode')

@section('mngpromoActive', 'active')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Promocode') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('quantity.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="quantity">{{ __('Quantity') }}</label>
                                <input id="quantity" type="number" min="0" max="{{$product->quantity ?? 1}}" value="{{$quantity}}" class="form-control-range required @error('quantity') is-invalid @enderror" name="quantity" required autofocus>
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Update cart') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
