@extends('layouts.app')

@section('title', 'Editing '. $product->name)


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
                    <div class="card-header">{{ __('Edit Product') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="totalSales" value="{{ $product->total_sales }}">

                            <div class="form-group">

                                <label for="id">{{ __('ID') }}</label>
                                <input id="id" type="text" class="form-control @error('id') is-invalid @enderror" value="{{ ucfirst(trans($product->id)) }}" disabled>

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control required @error('name') is-invalid @enderror" name="name" value="{{ ucfirst(trans($product->name)) }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Stock">{{ __('Stock') }}</label>
                                <input id="Stock" type="number" class="form-control required @error('quantity') is-invalid @enderror" name="quantity" value="{{ $product->quantity }}" required autocomplete="quantity">

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sold">{{ __('Sold') }}</label>
                                <input id="sold" type="number" class="form-control required @error('sold') is-invalid @enderror" name="sold" value="{{ $product->total_sales }}" required>

                                @error('sold')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cost">{{ __('Cost') }}</label>
                                <input id="cost" type="number" class="form-control required @error('cost') is-invalid @enderror" name="cost" value="{{$product->cost}}" required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price"  class="form-label">{{ __('Price') }}</label>
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{$product->price}}">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Save Changes') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
