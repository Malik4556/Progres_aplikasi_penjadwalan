@extends('layouts.mainlayout')

@section('title', 'Edit Data Kesediaan Dosen-Waktu')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Kesediaan Dosen-Waktu</h4>
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

    <div class="card shadow-sm" style="margin-top: 20px;">
        <div class="card-header bg-primary thin-card-header">
        </div>
        <div class="card-body">
            <form action="/dosenwaktu/{{ $dosenwaktu->id }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="dosen_id">Nama Dosen</label>
                    <select class="form-control" name="dosen_id" id="dosen_id" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ $dosenwaktu->dosen_id == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="hari_id">Hari</label>
                    <select class="form-control" name="hari_id" id="hari_id" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($haris as $hari)
                        <option value="{{ $hari->id }}" {{ $dosenwaktu->hari_id == $hari->id ? 'selected' : '' }}>{{ $hari->hari }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jam_id">Waktu</label>
                    <select class="form-control" name="jam_id" id="jam_id" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($jams as $jam)
                        <option value="{{ $jam->id }}" {{ $dosenwaktu->jam_id == $jam->id ? 'selected' : '' }}>{{ $jam->range_jam }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success">
                        <i class="lni lni-pencil"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
