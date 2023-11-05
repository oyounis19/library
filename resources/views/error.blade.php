@extends('layouts.app')

@section('title', 'Error '. $code ?? null)

@section('content')
<div class="text-center">
    <div class="error mx-auto" data-text="{{$code ?? null}}">{{$code ?? null}}</div>
    <p class="lead text-gray-800 mb-5">
        @if ($code == 403)
            Forbidden page
        @else
            Page Not Found
        @endif
    </p>
    <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
    <a href="{{route('dashboard')}}">← Back to Dashboard</a>
</div>
@endsection
