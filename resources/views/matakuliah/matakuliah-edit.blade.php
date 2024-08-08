@extends('layouts.mainlayout')

@section('title', 'Edit Data Matakuliah')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Mata Kuliah</h4>
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

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary thin-card-header">
        </div>
        <div class="card-body">
            <form action="/matakuliah/{{ $matakuliah->id }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="kode_mk">Kode MK</label>
                    <input type="text" class="form-control" name="kode_mk" id="kode_mk" value="{{ $matakuliah->kode_mk }}">
                </div>

                <div class="mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="{{ $matakuliah->nama }}">
                </div>

                <div class="mb-3">
                    <label for="sks">SKS</label>
                    <input type="text" class="form-control" name="sks" id="sks" value="{{ $matakuliah->sks }}">
                </div>

                <div class="mb-3">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester" value="{{ $matakuliah->semester }}">
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success d-flex align-items-center">
                        <i class="lni lni-pencil me-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
