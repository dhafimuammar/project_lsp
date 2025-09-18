@extends('layouts.app')

@section('content')

<div class="card mt-4">
    <div class="card-body">
        <h4 class="mb-3">Arsip Surat &gt;&gt; Lihat</h4>
        <div class="mb-2">
            <b>Nomor:</b> {{ $letter->nomor_surat }}<br>
            <b>Kategori:</b> {{ $letter->category->nama }}<br>
            <b>Judul:</b> {{ $letter->judul }}<br>
            <b>Waktu Unggah:</b> {{ $letter->created_at->format('Y-m-d H:i') }}
        </div>
        <div class="mb-4" style="background:#eee;min-height:420px;display:flex;align-items:center;justify-content:center;">
            @php
                $isPdf = $letter->file_path && strtolower(pathinfo($letter->file_path, PATHINFO_EXTENSION)) === 'pdf';
                $pdfUrl = asset('storage/' . $letter->file_path);
            @endphp
            @if($isPdf)
                {{-- Gunakan route yang men-stream PDF supaya header dikontrol oleh aplikasi --}}
                <iframe src="{{ route('letters.view', $letter->id) }}" width="80%" height="400px" style="border:1px solid #ccc;background:#fff;"></iframe>
                <noscript>
                    <div class="text-danger">Browser Anda tidak mendukung iframe PDF. <a href="{{ route('letters.view', $letter->id) }}" target="_blank">Klik di sini untuk membuka file PDF</a>.</div>
                </noscript>
            @else
                <div class="text-danger">File surat tidak ditemukan, belum diunggah, atau bukan file PDF.</div>
            @endif
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('letters.index') }}" class="btn btn-secondary">&lt;&lt; Kembali</a>
            <a href="{{ route('letters.download', $letter->id) }}" class="btn btn-warning">Unduh</a>
            <a href="{{ route('letters.edit', $letter->id) }}" class="btn btn-info">Edit / Ganti File</a>
        </div>
    </div>
</div>
@endsection
