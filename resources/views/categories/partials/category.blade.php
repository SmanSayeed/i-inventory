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
                {{-- Pass each child category recursively --}}
                @include('categories.partials.category', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
