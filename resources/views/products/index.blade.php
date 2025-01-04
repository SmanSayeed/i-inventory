@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Products</h1>

    <!-- Buttons Row -->
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>
        <a href="{{ route('export.list') }}" class="btn btn-info">View Exported Files</a>
        <button id="export-products-btn" class="btn btn-primary" onclick="exportProducts()">Export Products to Excel</button>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Define the exportProducts function globally
    function exportProducts() {
        alert('Exporting products. Please wait.');

        $.ajax({
            url: '{{ url('/api/export-products') }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = response.url; // Automatically download the file
                } else {
                    alert('Failed: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('An error occurred: ' + xhr.responseText);
                console.error(xhr.responseText);
            }
        });
    }
</script>
@endsection
