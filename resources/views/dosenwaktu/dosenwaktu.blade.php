@extends('layouts.mainlayout')

@section('title', 'Dosen-Waktu')

@section('content')

<h4 class="mt-1 mb-1">Daftar Kesediaan Dosen-Waktu</h4>
<hr class="thick-hr" style="margin-bottom: 75px;">

<!-- Status Proses -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Status Proses</h5>
    </div>
    <div class="card-body d-flex justify-content-between align-items-center">
        <p class="mb-0">
            Status:
            <span id="status-badge" class="badge {{ $statusdoswak ? 'bg-success' : 'bg-danger' }}">
                {{ $statusdoswak ? 'Selesai' : 'Belum Selesai' }}
            </span>
        </p>
        <button type="button" class="btn btn-primary" onclick="updateStatus()">
            <span id="status-button-text">{{ $statusdoswak ? 'Tandai Belum Selesai' : 'Tandai Selesai' }}</span>
        </button>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="/dosenwaktu-add" class="btn btn-primary d-flex align-items-center">
        <i class="lni lni-circle-plus me-2"></i> Tambah Data
    </a>
    <form action="" method="get" class="d-flex">
        <input type="text" class="form-control me-2 thick-border" name="keyword" placeholder="Masukkan kata kunci">
        <button class="btn btn-primary">Cari</button>
    </form>
</div>

@if(Session::has('status'))
<div class="alert alert-success" role="alert">
    {{ Session::get('message') }}
</div>
@endif

<div class="table-responsive mt-1">
    <table class="table table-striped table-bordered custom-table">
        <thead class="sticky-header">
            <tr class="text-center">
                <th style="width: 5%;">No.</th>
                <th style="width: 30%;">Nama Dosen</th>
                <th style="width: 10%;">Hari</th>
                <th style="width: 15%;">Waktu</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dosenwaktuList as $data)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-start">{{ $data->dosen->nama }}</td>
                <td class="text-center">{{ $data->hari->hari }}</td>
                <td class="text-center">{{ $data->jam->range_jam }}</td>
                <td class="text-center">
                    <div class="d-inline-flex">
                        <a href="/dosenwaktu-edit/{{ $data->id }}" class="btn btn-warning btn-sm d-flex align-items-center me-2">
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
                            <p>Apakah Anda yakin ingin menghapus data kesediaan waktu dosen</p> <p><strong>{{ $data->dosen->nama }}</strong></p>?
                        </div>
                        <div class="modal-footer d-flex justify-content-center"> <!-- Tambahkan d-flex justify-content-center di sini -->
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ url('/dosenwaktu-destroy/' . $data->id) }}" method="post" class="d-inline">
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

<!-- Formulir tersembunyi untuk status -->
<form id="status-form" style="display: none;">
    @csrf
    @method('post')
</form>

<script>
    function updateStatus() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ url('/update-status-dosenwaktu') }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('status-badge').className = 'badge ' + (response.status ? 'bg-success' : 'bg-danger');
                document.getElementById('status-badge').innerText = response.status ? 'Selesai' : 'Belum Selesai';
                document.getElementById('status-button-text').innerText = response.status ? 'Tandai Belum Selesai' : 'Tandai Selesai';
            } else {
                console.error('Error:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error('Request failed');
        };
        xhr.send(new FormData(document.getElementById('status-form')));
    }
</script>

@endsection
