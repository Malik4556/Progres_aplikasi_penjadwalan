@extends('layouts.mainlayout')

@section('title', 'Tambah Data Hari')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Tambah Data Jam</h4>
    <hr class="thick-hr" style="margin-bottom: 50px;">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary thin-card-header">
        </div>
        <div class="card-body">
            <form action="{{ route('jam.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jam_mulai">Jam Mulai:</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" style="width: 500px;" required>
                </div>
                <div class="mb-3">
                    <label for="jam_selesai">Jam Selesai:</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" style="width: 500px;" required>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success d-flex align-items-center me-2">
                        <i class="lni lni-save me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
