@extends('layouts.mainlayout')

@section('title', 'Tambah Data Dosen-Matakuliah')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Tambah Data Dosen-Mata Kuliah</h4>
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
        <div class="card-header bg-primary thin-card-header"></div>
        <div class="card-body">
            <form action="/dosenmatkul" method="post">
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
                    <label for="semester">Semester</label>
                    <select class="form-control" name="semester" id="semester" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester }}">{{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="matakuliah_id">Nama Matakuliah</label>
                    <select class="form-control" name="matakuliah_id" id="matakuliah_id" style="width: 500px;">
                        <option value="">Pilih Semester Terlebih Dahulu</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sks">SKS</label>
                    <input type="text" class="form-control" name="sks" id="sks" readonly style="width: 500px;">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#semester').change(function() {
            var semester = $(this).val();
            if (semester) {
                $.ajax({
                    url: '/get-matakuliah-by-semester',
                    type: 'GET',
                    data: { semester: semester },
                    success: function(data) {
                        $('#matakuliah_id').empty();
                        $('#matakuliah_id').append('<option value="">Pilih Salah Satu</option>');
                        $.each(data, function(key, value) {
                            $('#matakuliah_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
                        });
                    }
                });
            } else {
                $('#matakuliah_id').empty();
                $('#matakuliah_id').append('<option value="">Pilih Semester Terlebih Dahulu</option>');
            }
        });

        $('#matakuliah_id').change(function() {
            var matakuliah_id = $(this).val();
            if (matakuliah_id) {
                $.ajax({
                    url: '/get-sks-by-matakuliah',
                    type: 'GET',
                    data: { matakuliah_id: matakuliah_id },
                    success: function(data) {
                        $('#sks').val(data.sks);
                    }
                });
            } else {
                $('#sks').val('');
            }
        });
    });
</script>

@endsection
