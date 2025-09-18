@extends('layouts.app')

@section('content')

<h2 class="mt-4">Arsip Surat >> Edit</h2>
<form method="POST" action="{{ route('letters.update', $letter->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nomor_surat" class="form-label">Nomor Surat</label>
        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $letter->nomor_surat) }}" required>
    </div>
    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-select" id="kategori_id" name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $cat->id == old('kategori_id', $letter->kategori_id) ? 'selected' : '' }}>{{ $cat->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $letter->judul) }}" required>
    </div>
    <div class="mb-3">
        <label for="file_surat" class="form-label">Ganti File Surat (opsional, PDF)</label>
        <input type="file" class="form-control" id="file_surat" name="file_surat" accept="application/pdf">
        @if($letter->file_path)
            <small class="form-text text-muted">File saat ini: <a href="{{ route('letters.view', $letter->id) }}" target="_blank">Lihat</a></small>
        @endif
    </div>
    <a href="{{ route('letters.show', $letter->id) }}" class="btn btn-secondary"><< Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
@if($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
@endsection
