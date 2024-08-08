@extends('layouts.mainlayout')

@section('title', 'Hapus Data Dosen')

@section('content')

<div class="container mt-5" style="padding-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-white">
                    <h2 class="card-title">Konfirmasi Penghapusan</h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <p class="card-text text-center">Apakah Anda yakin ingin menghapus data dosen: <strong>{{$dosen->nama}}</strong>?</p>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="/dosen" class="btn btn-secondary me-3">Batal</a>
                        <form action="/dosen-destroy/{{ $dosen->id }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
