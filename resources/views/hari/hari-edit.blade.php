@extends('layouts.mainlayout')

@section('title', 'Edit Data Hari')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Hari</h4>
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
            <form action="/hari/{{ $hari->id }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" name="id" id="id" value="{{ old('id', $hari->id) }}" style="width: 500px;" readonly>
                </div>
                <div class="mb-3">
                    <label for="hari">Hari</label>
                    <input type="text" class="form-control" name="hari" id="hari" value="{{ old('hari', $hari->hari) }}" placeholder="Masukkan Nama Hari" style="width: 500px;">
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
