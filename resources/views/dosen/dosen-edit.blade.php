@extends('layouts.mainlayout')

@section('title', 'Edit Data Dosen')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Dosen</h4>
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
            <form action="/dosen/{{$dosen->id}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="kode_dos">Kode Dosen</label>
                    <input type="text" class="form-control" name="kode_dos" id="kode_dos" value="{{$dosen->kode_dos}}" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="{{$dosen->nama}}" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{$dosen->email}}" style="width: 500px;">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success d-flex align-items-center me-2">
                        <i class="lni lni-pencil me-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
