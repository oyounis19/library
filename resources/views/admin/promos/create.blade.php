@extends('layouts.app')

@section('title', 'Create Promocode')

@section('cpromoActive', 'active')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }} <br>
                <strong @style('font-size: 30px;')>{{session('code')}}</strong>
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
                    <div class="card-header">{{ __('Create Promocode') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('promos.store') }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="form-group">
                                <label for="discount">{{ __('Discount') }}</label>
                                <input id="discount" type="range" min="1" max="100" value="20" class="form-control-range required @error('discount') is-invalid @enderror" name="discount" required autocomplete="discount">
                                <strong @style('font-size: 45px;')><output id="output">20%</output></strong>
                                @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // JavaScript (jQuery)
        $(document).ready(function() {
            var rangeInput = $('#discount');
            var outputElement = $('#output');

            rangeInput.on('input', function() {
                var valueWithPercent = rangeInput.val() + '%';
                outputElement.text(valueWithPercent);
            });
        });
    </script>
@endpush
