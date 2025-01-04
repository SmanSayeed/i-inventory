@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

    @if($categories->count())
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item">
                    <strong>{{ $category->name }}</strong>
                    <p>{{ $category->description }}</p>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>

                    @if($category->children->count())
                        <ul class="mt-2">
                            @foreach($category->children as $child)
                                <li>
                                    <strong>{{ $child->name }}</strong>
                                    <p>{{ $child->description }}</p>
                                    <a href="{{ route('categories.edit', $child) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('categories.destroy', $child) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No categories available.</p>
    @endif
</div>
@endsection
