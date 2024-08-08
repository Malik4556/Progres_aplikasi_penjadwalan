@extends('layouts.mainlayout')

@section('title', 'Status Progres')

@section('content')

<h4 class="mt-4 mb-3">Status Progres</h4>
<hr class="thick-hr" style="margin-bottom: 75px;">

@include('status.mahasiswa')
@include('status.dosen_waktu')
@include('status.dosen_matkul')

<script>
    function updateStatus(entityType) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ url('/update-status') }}', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (entityType === 'mahasiswa') {
                    document.getElementById('status-mahasiswa-badge').className = 'badge ' + (response.status ? 'bg-success' : 'bg-danger');
                    document.getElementById('status-mahasiswa-badge').innerText = response.status ? 'Selesai' : 'Belum Selesai';
                    document.getElementById('status-mahasiswa-button-text').innerText = response.status ? 'Tandai Belum Selesai' : 'Tandai Selesai';
                } else if (entityType === 'dosen_waktu') {
                    document.getElementById('status-dosen-waktu-badge').className = 'badge ' + (response.status ? 'bg-success' : 'bg-danger');
                    document.getElementById('status-dosen-waktu-badge').innerText = response.status ? 'Selesai' : 'Belum Selesai';
                    document.getElementById('status-dosen-waktu-button-text').innerText = response.status ? 'Tandai Belum Selesai' : 'Tandai Selesai';
                } else if (entityType === 'dosen_matkul') {
                    document.getElementById('status-dosen-matkul-badge').className = 'badge ' + (response.status ? 'bg-success' : 'bg-danger');
                    document.getElementById('status-dosen-matkul-badge').innerText = response.status ? 'Selesai' : 'Belum Selesai';
                    document.getElementById('status-dosen-matkul-button-text').innerText = response.status ? 'Tandai Belum Selesai' : 'Tandai Selesai';
                }
            }
        };
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('entity_type=' + encodeURIComponent(entityType));
    }
</script>

@endsection
