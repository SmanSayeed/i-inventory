@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($categories as $parentCategory)
                    <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="child-category-container" style="display: none;">
            <label for="child_id" class="form-label">Child Category</label>
            <select name="child_id" id="child_id" class="form-control">
                <option value="">-- Select Child Category --</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#parent_id').on('change', function () {
            const parentId = $(this).val();
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
                                $('#child_id').append('<option value="' + category.id + '">' + category.name + '</option>');
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
        });
    });
</script>
@endsection
