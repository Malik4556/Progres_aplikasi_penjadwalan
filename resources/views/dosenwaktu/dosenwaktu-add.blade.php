@extends('layouts.mainlayout')

@section('title', 'Tambah Data Dosen-Matakuliah')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Tambah Data Kesediaan Dosen-Waktu</h4>
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
            <form action="/dosenwaktu" method="post">
                @csrf

                <div class="mb-3">
                    <label for="dosen_id">Nama Dosen</label>
                    <select class="form-control" name="dosen_id" id="dosen_id" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="hari_id">Hari Kesediaan</label>
                    <select class="form-control" name="hari_id" id="hari_id" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($haris as $hari)
                        <option value="{{ $hari->id }}">{{ $hari->hari }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jam_id">Waktu Kesediaan</label>
                    <select class="form-control" name="jam_id" id="jam_id" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($jams as $jam)
                        <option value="{{ $jam->id }}">{{ $jam->range_jam }}</option>
                        @endforeach
                    </select>
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
