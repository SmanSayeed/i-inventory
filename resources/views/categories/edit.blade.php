@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ $category->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($categories as $parentCategory)
                    <option value="{{ $parentCategory->id }}"
                        @if($category->parent_id == $parentCategory->id) selected @endif>
                        {{ $parentCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>
@endsection
