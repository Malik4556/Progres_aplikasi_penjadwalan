@extends('layouts.mainlayout')

@section('title', 'Edit Data Dosen-Matakuliah')

@section('content')

<div class="container mt-4">
    <h4 class="mb-3">Rubah Data Kesediaan Dosen-Mata Kuliah</h4>
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

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-primary thin-card-header">
        </div>
        <div class="card-body">
            <form action="/dosenmatkul/{{ $dosenmatkul->id }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-control" name="semester" id="semester" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester }}" {{ $dosenmatkul->semester == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dosen_id" class="form-label">Nama Dosen</label>
                    <select class="form-control" name="dosen_id" id="dosen_id" style="width: 500px;">
                        <option value="">Pilih Salah Satu</option>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ $dosenmatkul->dosen_id == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="matakuliah_id" class="form-label">Nama Matakuliah</label>
                    <select class="form-control" name="matakuliah_id" id="matakuliah_id" style="width: 500px;">
                        <option value="">Pilih Semester Terlebih Dahulu</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sks">SKS</label>
                    <input type="text" class="form-control" name="sks" id="sks" readonly style="width: 500px;">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Memilih semester yang sedang diedit
        var editedSemester = '{{ $dosenmatkul->semester }}';
        var editedMatakuliahId = '{{ $dosenmatkul->matakuliah_id }}';

        // Menampilkan matakuliah yang sesuai dengan semester yang sedang diedit
        if (editedSemester) {
            $.ajax({
                url: '/get-matakuliah-by-semester',
                type: 'GET',
                data: { semester: editedSemester },
                success: function(data) {
                    $('#matakuliah_id').empty();
                    $('#matakuliah_id').append('<option value="">Pilih Salah Satu</option>');
                    $.each(data, function(key, value) {
                        var selected = value.id == editedMatakuliahId ? 'selected' : '';
                        $('#matakuliah_id').append('<option value="' + value.id + '" ' + selected + '>' + value.nama + '</option>');
                    });

                    // Memuat SKS untuk matakuliah yang sedang diedit
                    if (editedMatakuliahId) {
                        loadSks(editedMatakuliahId);
                    }
                }
            });
        }

        // Ajax untuk memuat matakuliah berdasarkan perubahan semester
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

        // Ajax untuk memuat SKS berdasarkan perubahan matakuliah
        $('#matakuliah_id').change(function() {
            var matakuliahId = $(this).val();
            loadSks(matakuliahId);
        });

        function loadSks(matakuliahId) {
            if (matakuliahId) {
                $.ajax({
                    url: '/get-sks-by-matakuliah',
                    type: 'GET',
                    data: { matakuliah_id: matakuliahId },
                    success: function(data) {
                        $('#sks').val(data.sks);
                    }
                });
            } else {
                $('#sks').val('');
            }
        }
    });
</script>

@endsection
