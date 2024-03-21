@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    @push('css-plugins')
    @endpush

    @include('components.navbar-admin')

    <div class="card container">
        <div class="card-body">
            This is some text within a card body.
        </div>
    </div>

    <div class="card container">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
    </div>

    @push('javascript-plugins')
    @endpush
@endsection
