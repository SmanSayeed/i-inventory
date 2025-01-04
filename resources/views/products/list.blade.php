@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Exported Files</h1>

    <!-- Display each exported file with a download button -->
    @if(count($files) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                    <tr>
                        <td>{{ $file->getFilename() }}</td>
                        <td>
                            <!-- Button to download the file -->
                            <a href="{{ route('export.download', $file->getFilename()) }}" class="btn btn-primary btn-sm">Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No exported files available.</p>
    @endif
</div>
@endsection
