@extends('layouts.mainlayout')

@section('title', 'View Mahasiswa')

@section('content')

<h4 class="mt-1 mb-1">Daftar Jumlah Mahasiswa</h4>
<hr class="thick-hr" style="margin-bottom: 75px;">

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="flex-grow-1"></div>
    <form action="" method="get" class="d-flex">
        <input type="text" class="form-control me-2 thick-border" name="keyword" placeholder="Masukkan kata kunci">
        <button class="btn btn-primary">Cari</button>
    </form>
</div>

<p class="mb-1">
    Status:
    <span id="status-badge" class="badge {{ $status ? 'bg-success' : 'bg-danger' }}">
        {{ $status ? 'Selesai' : 'Belum Selesai' }}
    </span>
</p>

@if(Session::has('status'))
<div class="alert alert-success" role="alert">
    {{ Session::get('message') }}
</div>
@endif

<div class="table-responsive mt-1">
    <table class="table table-striped table-bordered custom-table">
        <thead class="thead-dark sticky-header">
            <tr class="text-center">
                <th style="width: 5%;">No.</th>
                <th style="width: 40%;">Angkatan</th>
                <th style="width: 15%;">Semester</th>
                <th style="width: 40%;">Jumlah Mahasiswa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswaList as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->angkatan }}</td>
                <td>{{ $data->semester }}</td>
                <td>{{ $data->jml_mahasiswa }}</td>
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

        fetch('/update-status', {
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
