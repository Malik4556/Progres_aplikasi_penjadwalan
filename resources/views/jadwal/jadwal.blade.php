@extends('layouts.mainlayout')

@section('title', 'Jadwal')

@section('content')

    <h4 class="mt-1 mb-1">Jadwal Perkuliahan</h4>
    <hr class="thick-hr mb-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary thin-card-header"></div>
        <div class="card-body">
            <form action="{{ route('jadwal.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="lni lni-reload me-2"></i> Buat Jadwal
                </button>
            </form>
        </div>
    </div>

    @if (Session::has('message'))
        <div class="alert alert-{{ Session::get('status') }}">
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <a href="/viewer-mahasiswa" class="btn btn-primary d-flex align-items-center me-2">
            <i class="lni lni-list me-2"></i> Data Jumlah Mahasiswa
        </a>

        <a href="{{ route('kelas.deleteAll') }}" class="btn btn-danger d-flex align-items-center me-2"
            onclick="return confirmDelete(event)">
            <i class="lni lni-trash-can me-2"></i> Hapus Daftar Kelas
        </a>

        <form action="" method="get" class="d-flex ms-auto">
            <input type="text" class="form-control me-2" name="keyword" placeholder="Masukkan kata kunci">
            <button class="btn btn-primary">Cari</button>
        </form>
    </div>

    <div class="table-responsive mt-1">
        <table class="table table-striped table-bordered custom-table">
            <thead class="sticky-header">
                <tr class="text-center">
                    <th style="width: 5%;">No.</th>
                    <th style="width: 20%;">Nama Dosen</th>
                    <th style="width: 10%;">Kelas</th>
                    <th style="width: 10%;">Semester</th>
                    <th style="width: 20%;">Mata Kuliah</th>
                    <th style="width: 5%;">SKS</th>
                    <th style="width: 10%;">Hari</th>
                    <th style="width: 10%;">Jam Mulai</th>
                    <th style="width: 10%;">Jam Selesai</th>
                    <th style="width: 10%;">Ruangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwalList as $jadwal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $jadwal->nama_dosen }}</td>
                        <td>{{ $jadwal->nama_kelas }}</td>
                        <td>{{ $jadwal->semester }}</td>
                        <td>{{ $jadwal->nama_matakuliah }}</td>
                        <td>{{ $jadwal->sks }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->jam_mulai }}</td>
                        <td>{{ $jadwal->jam_selesai }}</td>
                        <td>{{ $jadwal->no_ruangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data jadwal</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
