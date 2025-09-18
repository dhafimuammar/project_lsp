@extends('layouts.app')

@section('content')

<h2 class="mt-4">Arsip Surat &gt;&gt; Unggah</h2>
<p>Unggah surat yang telah terbit pada form ini untuk diarsipkan.<br>Catatan: Gunakan file berformat PDF</p>
<form method="POST" action="{{ route('letters.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nomor_surat" class="form-label">Nomor Surat</label>
        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $generated ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-select" id="kategori_id" name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                @if($cat->nama == 'Undangan')
                    <option value="{{ $cat->id }}">Undangan</option>
                @elseif($cat->nama == 'Pengumuman')
                    <option value="{{ $cat->id }}">Pengumuman</option>
                @elseif($cat->nama == 'Nota Dinas')
                    <option value="{{ $cat->id }}">Nota Dinas</option>
                @elseif($cat->nama == 'Pemberitahuan')
                    <option value="{{ $cat->id }}">Pemberitahuan</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" required>
    </div>
    <div class="mb-3">
        <label for="file_surat" class="form-label">File Surat (PDF)</label>
        <input type="file" class="form-control" id="file_surat" name="file_surat" accept="application/pdf" required>
        <small class="text-muted">Hanya file PDF yang diperbolehkan.</small>
    </div>
    <a href="{{ route('letters.index') }}" class="btn btn-secondary">&lt;&lt; Kembali</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
@endsection
