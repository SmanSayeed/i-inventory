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
                    <option value="{{ $parentCategory->id }}" @if($category->parent_id == $parentCategory->id) selected @endif>
                        {{ $parentCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="child-category-container" style="display: none;">
            <label for="child_id" class="form-label">Child Category</label>
            <select name="child_id" id="child_id" class="form-control">
                <option value="">-- Select Child Category --</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const loadChildren = function (parentId, selectedChildId = null) {
            if (parentId) {
                $.ajax({
                    url: "{{ route('categories.children') }}",
                    type: 'GET',
                    data: { parent_id: parentId },
                    success: function (data) {
                        if (data.length > 0) {
                            $('#child-category-container').show();
                            $('#child_id').empty().append('<option value="">-- Select Child Category --</option>');
                            $.each(data, function (index, category) {
                                $('#child_id').append('<option value="' + category.id + '"' +
                                    (category.id == selectedChildId ? ' selected' : '') +
                                    '>' + category.name + '</option>');
                            });
                        } else {
                            $('#child-category-container').hide();
                            $('#child_id').empty();
                        }
                    }
                });
            } else {
                $('#child-category-container').hide();
                $('#child_id').empty();
            }
        };

        const parentId = $('#parent_id').val();
        const selectedChildId = "{{ $category->child_id ?? '' }}";
        if (parentId) {
            loadChildren(parentId, selectedChildId);
        }

        $('#parent_id').on('change', function () {
            loadChildren($(this).val());
        });
    });
</script>
@endsection
