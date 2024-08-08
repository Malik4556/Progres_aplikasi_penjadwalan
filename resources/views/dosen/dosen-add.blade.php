@extends('layouts.mainlayout')

@section('title', 'Tambah Data Dosen')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Tambah Data Dosen</h4>
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
        <div class="card-header bg-primary thin-card-header">
        </div>
        <div class="card-body">
            <form action="/dosen" method="post">
                @csrf
                <div class="mb-3">
                    <label for="kode_dos">Kode Dosen</label>
                    <input type="text" class="form-control" name="kode_dos" id="kode_dos"
                        placeholder="Masukkan Kode Dosen" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama"
                        placeholder="Masukkan Nama Dosen" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email"
                        placeholder="Masukkan E-mail Dosen" style="width: 500px;">
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
