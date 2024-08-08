@extends('layouts.mainlayout')

@section('title', 'Tambah Data Ruangan')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Tambah Data Ruangan</h4>
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
            <form action="/ruangan" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="no_ruangan" class="form-label">Nomor Ruangan</label>
                    <input type="text" class="form-control thick-border" id="no_ruangan" name="no_ruangan"
                                placeholder="Masukkan Nomor Ruangan" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="text" class="form-control thick-border" id="kapasitas" name="kapasitas"
                                placeholder="Masukkan Jumlah Kapasitas Ruangan" style="width: 500px;">
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
