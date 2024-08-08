@extends('layouts.mainlayout')

@section('title', 'Kelas')

@section('content')

    <h4 class="mt-1 mb-1">Daftar Kelas</h4>
    <hr class="thick-hr mb-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary thin-card-header"></div>
        <div class="card-body">
            <form action="{{ route('kelas.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="lni lni-reload me-2"></i> Buat Kelas
                </button>
            </form>
        </div>
    </div>

    @if (Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <a href="/viewer-mahasiswa" class="btn btn-primary d-flex align-items-center me-2">
            <i class="lni lni-list me-2"></i> Data Jumlah Mahasiswa
        </a>

        <a href="{{ route('kelas.deleteAll') }}" class="btn btn-danger d-flex align-items-center me-2" onclick="return confirm('Apakah Anda yakin ingin menghapus semua data kelas?')">
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
                    <th style="width: 15%;">Jenis Semester</th>
                    <th style="width: 20%;">Angkatan</th>
                    <th style="width: 20%;">Kelas</th>
                    <th style="width: 20%;">Semester</th>
                    <th style="width: 20%;">Jumlah Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelasList as $kelas)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kelas->jenis_sem }}</td>
                        <td>{{ $kelas->angkatan }}</td>
                        <td>{{ $kelas->kelas }}</td>
                        <td>{{ $kelas->semester }}</td>
                        <td>{{ $kelas->jml_mahasiswa }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data kelas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
