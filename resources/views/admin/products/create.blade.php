@extends('layouts.app')

@section('title', 'Create New Product')

@section('addproductActive', 'active')

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
        @if (session('allerrors'))
            <div class="alert alert-danger">
                <ul>
                    @foreach(session('allerrors') as $subArray)
                        @foreach($subArray as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endforeach
                </ul>
                <h5>No Products were added.</h5>
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
                    <div class="card-header">{{ __('Create Product') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control required @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="Stock">{{ __('Stock') }}</label>
                                <input id="Stock" type="number" class="form-control required @error('quantity') is-invalid @enderror" name="quantity" min="1" required autocomplete="quantity">

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cost">{{ __('Cost') }}</label>
                                <input id="cost" type="number" class="form-control required @error('cost') is-invalid @enderror" name="cost" required>

                                @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price"  class="form-label">{{ __('Price') }}</label>
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Create Product') }}
                            </button>
                        </form>
                        <h2 class="my-4">Or</h2>
                        <form action="{{route('products.store.excel')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="form-group">
                                <label for="excel">{{ __('Upload Excel File (.xlsx)') }}</label>
                                <input id="excel" type="file" class="form-control required @error('file') is-invalid @enderror" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>

                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Upload File') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
