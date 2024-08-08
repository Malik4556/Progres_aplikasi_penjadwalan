@extends('layouts.mainlayout')

@section('title', 'Dashboard KD')

@section('page-name', 'dashboard_kd')

@section('content')
<div class="col-md-12">
    <h4 class="mt-2">Dashboard</h4>
    <hr>
    <div class="container-fluid bg-light" style="min-height: calc(100vh - 112px); padding-top: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-4 text-center">
                <div class="card mt-4 shadow-lg" style="height: 400px;">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Kampus" style="max-height: 250px;">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mt-4 shadow-lg">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Selamat datang, {{ $user->username }}!</h1>
                        <p class="lead text-center">Divisi: {{ $user->divisi }}</p>
                        <hr>
                        <p class="text-center">Sekolah Tinggi Teknologi Bandung (STTB) berdiri sejak 1991, dan pada Maret 2024 Sekolah Tinggi Teknologi Bandung berubah bentuk menjadi Universitas Teknologi Bandung (UTB).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
