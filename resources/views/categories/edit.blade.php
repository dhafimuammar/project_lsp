@extends('layouts.app')

@section('content')

<h2 class="mt-4">Kategori Surat &gt;&gt; Edit</h2>
<form method="POST" action="{{ route('categories.update', $category->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">ID (Auto Increment)</label>
        <input type="text" class="form-control" value="{{ $category->id }}" disabled>
    </div>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Kategori</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ $category->nama }}" required>
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">Judul/Keterangan (opsional)</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $category->keterangan }}</textarea>
    </div>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">&lt;&lt; Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
@endsection
