@extends('layout')

@section('title', 'Edit Tag')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Edit Tag</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('tags.update', $tag->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Tag</label>
                            <input type="text" name="nama" class="form-control" value="{{ $tag->nama }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tags.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-success">Update Tag</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
