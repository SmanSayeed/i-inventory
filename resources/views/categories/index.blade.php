@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

    @if($categories->count())
        <ul class="list-group">
            @foreach($categories as $category)
                {{-- Pass the top-level category to the recursive partial --}}
                @include('categories.partials.category', ['category' => $category])
            @endforeach
        </ul>
    @else
        <p>No categories available.</p>
    @endif
</div>
@endsection
