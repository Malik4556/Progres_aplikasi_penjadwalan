@extends('layouts.mainlayout')

@section('title', 'Edit Data Ruangan')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Ruangan</h4>
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
            <form action="/ruangan/{{$ruangan->id}}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="no_ruangan">Nomor Ruangan</label>
                    <input type="text" class="form-control" name="no_ruangan" id="no_ruangn"  value="{{$ruangan->no_ruangan}}" style="width: 500px;">
                </div>

                <div class="mb-3">
                    <label for="kapasitas">Kapasitas</label>
                    <input type="text" class="form-control" name="kapasitas" id="kapasitas" value="{{$ruangan->kapasitas}}" style="width: 500px;">
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
