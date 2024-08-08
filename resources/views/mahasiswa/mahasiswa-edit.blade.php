@extends('layouts.mainlayout')

@section('title', 'Edit Data Mahasiswa')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Jumlah Mahasiswa</h4>
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
        <div class="card-header bg-primary thin-card-header"></div>
        <div class="card-body">
            <form action="/mahasiswa/{{$mahasiswa->id}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="angkatan">Angkatan</label>
                    <input type="text" class="form-control" name="angkatan" id="angkatan" value="{{ $mahasiswa->angkatan }}" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester" value="{{ $mahasiswa->semester }}" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="jml_mahasiswa">Jumlah Mahasiswa</label>
                    <input type="text" class="form-control" name="jml_mahasiswa" id="jml_mahasiswa" value="{{ $mahasiswa->jml_mahasiswa }}" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <button class="btn btn-success d-flex align-items-center me-2">
                        <i class="lni lni-pencil me-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
