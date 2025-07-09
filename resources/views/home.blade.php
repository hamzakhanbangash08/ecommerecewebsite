@extends('layouts.master')

@section('title', 'Home Page')

@section('content')
<div class="row">
    <div class="col-md-12 text-center">
        <h1>Welcome to My Product Website</h1>
        <p class="lead">We offer high-quality products at affordable prices.</p>
        <a href="{{ url('/products') }}" class="btn btn-primary">View Products</a>
    </div>
</div>
@endsection