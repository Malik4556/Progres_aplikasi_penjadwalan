@extends('layouts.mainlayout')

@section('title', 'Tambah Data Matakuliah')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Tambah Data Mata Kuliah</h4>
    <hr style="margin-bottom: 50px;">

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
        <div class="card-header bg-primary thin-card-header">
        </div>
        <div class="card-body">
            <form action="/matakuliah" method="post">
                @csrf
                <div class="mb-3">
                    <label for="kode_mk" class="form-label">Kode MK</label>
                    <input type="text" class="form-control" name="kode_mk" id="kode_mk"
                                placeholder="Masukkan Kode Matakuliah" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester"
                                placeholder="Masukkan Data Semester"style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="Masukkan Nama Matakuliah" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="text" class="form-control" name="sks" id="sks"
                                placeholder="Masukkan Jumlah SKS" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success d-flex align-items-center">
                        <i class="lni lni-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
