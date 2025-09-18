@extends('layouts.app')

@section('content')

<h2 class="mt-4">Kategori Surat</h2>
<p>Berikut ini adalah kategori yang bisa digunakan untuk melabeli surat.<br>Klik "Tambah" pada kolom aksi untuk menambah kategori baru.</p>
<form method="GET" action="{{ route('categories.index') }}" class="mb-3 d-flex">
  <input type="text" name="search" class="form-control w-25" placeholder="Cari ID, nama, atau keterangan" value="{{ request('search') }}">
  <button type="submit" class="btn btn-dark ms-2">Cari!</button>
</form>
<table class="table table-bordered">
    <thead>
    <tr>
      <th>ID Kategori</th>
      <th>Nama Kategori</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
        @forelse($categories as $cat)
    <tr>
      <td>{{ $cat->id }}</td>
      <td>{{ $cat->nama }}</td>
      <td>{{ $cat->keterangan }}</td>
      <td>
                <form method="POST" action="{{ route('categories.destroy', $cat->id) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $cat->id }})">Hapus</button>
                </form>
                <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-primary btn-sm">Edit</a>
            </td>
        </tr>
        @empty
  <tr><td colspan="4" class="text-center">Data kategori belum ada.</td></tr>
        @endforelse
    </tbody>
</table>
<a href="{{ route('categories.create') }}" class="btn btn-success mt-2">[ + ] Tambah Kategori Baru...</a>

<!-- Modal konfirmasi hapus -->
<div class="modal" tabindex="-1" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alert</h5>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus kategori surat ini?</p>
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
        document.querySelector('form[action$="/' + deleteId + '"] button[type=\"button\"]').closest('form').submit();
    };
}
</script>
@endsection
