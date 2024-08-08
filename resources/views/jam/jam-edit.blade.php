@extends('layouts.mainlayout')

@section('title', 'Edit Data Jam')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Jam</h4>
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
            <form action="{{ route('jam.update', ['id' => $jam->id, 'page' => request()->query('page')]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="jam_mulai">Jam Mulai:</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai', explode(' - ', $jam->range_jam)[0]) }}" style="width: 500px;" required>
                </div>
                <div class="mb-3">
                    <label for="jam_selesai">Jam Selesai:</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai', explode(' - ', $jam->range_jam)[1]) }}" style="width: 500px;" required>
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
