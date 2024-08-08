@extends('layouts.mainlayout')

@section('title', 'Matakuliah')

@section('content')

<h4 class="mt-1 mb-1">Daftar Mata Kuliah</h4>
<hr class="thick-hr" style="margin-bottom: 75px;">

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="matakuliah-add" class="btn btn-primary d-flex align-items-center">
        <i class="lni lni-circle-plus me-2"></i> Tambah Data
    </a>
    <form action="" method="get" class="d-flex">
        <input type="text" class="form-control me-2 thick-border" name="keyword" placeholder="Masukkan kata kunci">
        <button class="btn btn-primary">Cari</button>
    </form>
</div>

@if(Session::has('status'))
    <div class="alert alert-success mt-3" role="alert">
        {{ Session::get('message') }}
    </div>
@endif

<div class="table-responsive mt-1">
    <table class="table table-striped table-bordered custom-table">
        <thead class="sticky-header">
            <tr class="text-center">
                <th style="width: 5%;">No.</th>
                <th style="width: 10%;">Semester</th>
                <th style="width: 15%;">Kode Matakuliah</th>
                <th style="width: 40%;">Nama</th>
                <th style="width: 10%;">SKS</th>
                <th style="width: 20%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($matakuliahList as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->semester }}</td>
                <td>{{ $data->kode_mk }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->sks }}</td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <a href="matakuliah-edit/{{ $data->id }}" class="btn btn-warning btn-sm d-flex align-items-center me-2">
                            <i class="lni lni-pencil me-2"></i> Edit
                        </a>
                        <button class="btn btn-danger btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $data->id }}">
                            <i class="lni lni-trash-can me-2"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="confirmDeleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $data->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-center"> <!-- Tambahkan text-center di sini -->
                        <div class="modal-header">
                            <h5 class="modal-title w-100" id="confirmDeleteModalLabel{{ $data->id }}">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah anda yakin ingin menghapus data matakuliah</p> <p><strong>{{ $data->nama }}</strong></p>?
                        </div>
                        <div class="modal-footer d-flex justify-content-center"> <!-- Tambahkan d-flex justify-content-center di sini -->
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ url('/matakuliah-destroy/' . $data->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

{{-- <div class="my-3">
    {{ $matakuliahList->withQueryString()->links() }}
</div> --}}

@endsection
