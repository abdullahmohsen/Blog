@extends('layouts/app')

@section('title')
    All Categories
@endsection

@section('styles')
    <style>
        h1 {
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>All Categories</h1>
            @auth
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Create new category</a>
                @endif
            @endauth
        </div>
    </div>

    @foreach($categories as $category)
        <hr>
        <a href="{{ route('categories.show', $category->id) }}">
            <h2>{{ $category->name }}</h2>
        </a>
        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-primary">Show</a>

        @auth
            @if(Auth::user()->role == 'admin')
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info">Edit</a>
                <a href="{{ route('categories.delete', $category->id) }}" class="btn btn-danger">Delete</a>
            @endif
        @endauth
    @endforeach

    <div class="my-5 w-100 d-flex justify-content-center">
        {!! $categories->render() !!} <!-- parser to HTML  -->
    </div>
@endsection

@section('scripts')



@endsection

