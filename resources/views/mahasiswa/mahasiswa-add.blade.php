@extends('layouts.mainlayout')

@section('title', 'Tambah Data Mahasiswa')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Tambah Data Jumlah Mahasiswa</h4>
    <hr class="thick-hr" style="margin-bottom: 50px;">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary thin-card-header"></div>
        <div class="card-body">
            <form action="/mahasiswa" method="post">
                @csrf
                <div class="mb-3">
                    <label for="angkatan">Angkatan</label>
                    <input type="text" class="form-control" name="angkatan" id="angkatan" placeholder="Masukkan Tahun Angkatan" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester" placeholder="Masukkan Semester" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="jml_mahasiswa">Jumlah Mahasiswa</label>
                    <input type="text" class="form-control" name="jml_mahasiswa" id="jml_mahasiswa" placeholder="Masukkan Jumlah Mahasiswa" style="width: 500px;">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success d-flex align-items-center me-2">
                        <i class="lni lni-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
