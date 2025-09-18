@extends('layouts.app')

@section('content')

<h2 class="mt-4">Arsip Surat</h2>
<p>Berikut ini adalah surat-surat yang telah terbit dan diarsipkan.<br>Klik "Lihat" pada kolom aksi untuk menampilkan surat.</p>
<form method="GET" action="{{ route('letters.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" class="form-control w-25" placeholder="search" value="{{ request('search') }}">
    <button type="submit" class="btn btn-dark ms-2">Cari!</button>
</form>
<table class="table table-bordered">
    <thead>
            <th>Nomor Surat</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Waktu Pengarsipan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($letters as $letter)
        <tr>
            <td>{{ $letter->nomor_surat }}</td>
            <td>{{ $letter->category->nama }}</td>
            <td>{{ $letter->judul }}</td>
            <td>{{ $letter->created_at->format('Y-m-d H:i') }}</td>
            <td>
                <form method="POST" action="{{ route('letters.destroy', $letter->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $letter->id }})">Hapus</button>
                </form>
                <a href="{{ route('letters.download', $letter->id) }}" class="btn btn-warning btn-sm">Unduh</a>
                <a href="{{ route('letters.show', $letter->id) }}" class="btn btn-primary btn-sm">Lihat &gt;&gt;</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Data surat belum ada.</td></tr>
        @endforelse
    </tbody>
</table>
<a href="{{ route('letters.create') }}" class="btn btn-dark mt-2">Arsipkan Surat..</a>

<!-- Modal konfirmasi hapus -->
<div class="modal" tabindex="-1" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alert</h5>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus arsip surat ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Ya!</button>
      </div>
    </div>
  </div>
</div>

<script>
let deleteId = null;
function confirmDelete(id) {
    deleteId = id;
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
    document.getElementById('confirmDeleteBtn').onclick = function() {
        document.querySelector('form[action$="/' + deleteId + '"] button[type="button"]').closest('form').submit();
    };
}
</script>
@endsection
