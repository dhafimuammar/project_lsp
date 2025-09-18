@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-2">
            <h2 class="mt-4">About</h2>
            <div class="d-flex align-items-center mt-4">
                @if (file_exists(public_path('foto.jpg')))
                    <img src="{{ asset('foto.jpg') }}" alt="foto.jpg" style="width:120px;height:120px;border-radius:10px;margin-right:32px;background:#ddd;object-fit:cover;">
                @else
                    <!-- Placeholder SVG when foto.jpg tidak ada di public/ -->
                    <img src="data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120'%3E%3Crect width='100%25' height='100%25' fill='%23ddd'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' fill='%23888' font-size='14'%3EFoto%3C/text%3E%3C/svg%3E" alt="placeholder" style="width:120px;height:120px;border-radius:10px;margin-right:32px;background:#ddd;object-fit:cover;">
                @endif
                <div>
                    <p>Aplikasi ini dibuat oleh:</p>
                    <table>
                        <tr><td>Nama</td><td>: Muammar Khadhafi</td></tr>
                        <tr><td>Prodi</td><td>: D3-MI PSDKU Kediri</td></tr>
                        <tr><td>NIM</td><td>: 2331730107</td></tr>
                        <tr><td>Tanggal</td><td>: 07 September 2025</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
