@extends('layouts.mainlayout')

@section('title', 'Dosen-Waktu')

@section('content')

<h4 class="mt-1 mb-1">Daftar Kesediaan Dosen-Waktu</h4>
<hr class="thick-hr" style="margin-bottom: 75px;">

<p class="mb-1">
    Status:
    <span id="status-badge" class="badge {{ $statusdoswak ? 'bg-success' : 'bg-danger' }}">
        {{ $statusdoswak ? 'Selesai' : 'Belum Selesai' }}
    </span>
</p>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="flex-grow-1"></div>
    <form action="" method="get" class="d-flex">
        <input type="text" class="form-control me-2 thick-border" name="keyword" placeholder="Masukkan kata kunci">
        <button class="btn btn-primary">Cari</button>
    </form>
</div>


    <div class="table-responsive mt-1">
        <table class="table table-striped table-bordered custom-table">
            <thead class="thead-dark sticky-header">
            <tr class="text-center">
                <th style="width: 5%;">No.</th>
                <th style="width: 50%;">Nama Dosen</th>
                <th style="width: 20%;">Hari</th>
                <th style="width: 25%;">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dosenwaktuList as $data)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-start">{{ $data->dosen->nama }}</td>
                <td class="text-center">{{ $data->hari->hari }}</td>
                <td class="text-center">{{ $data->jam->range_jam }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function updateStatus() {
        let statusBadge = document.getElementById('status-badge');
        let currentStatus = statusBadge.classList.contains('bg-success');
        let newStatus = !currentStatus;

        fetch('/update-status-dosenwaktu', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ completed: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            statusBadge.classList.toggle('bg-success', data.status);
            statusBadge.classList.toggle('bg-danger', !data.status);
            statusBadge.textContent = data.status ? 'Selesai' : 'Belum Selesai';
        });
    }

    // Tambahkan event listener untuk memanggil updateStatus() saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('status-badge').addEventListener('click', updateStatus);
    });
</script>

@endsection
