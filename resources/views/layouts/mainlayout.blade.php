<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penjadwalan @yield('title')</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="d-flex flex-grow-1">
        <aside id="sidebar" class="expand flex-shrink-0 ">
            <div class="text-center mt-3">
                <img src="{{ asset('images/logo2.png') }}" alt="Logo Kampus" class="img-fluid sidebar-logo">
            </div>
            <ul class="sidebar-nav ">
                @if (Auth::user()->role_id == 1)
                    <li class="sidebar-item">
                        <a href="dashboard_dap" class="sidebar-link">
                            <i class="lni lni-grid-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="ruangan" class="sidebar-link">
                            <i class="lni lni-apartment"></i>
                            <span>Ruangan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#auth2" aria-expanded="false" aria-controls="auth2">
                            <i class="lni lni-calendar"></i>
                            <span>Kesediaan Dosen</span>
                        </a>
                        <ul id="auth2" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="viewer-dosenwaktu" class="sidebar-link">Waktu</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="viewer-dosenmatkul" class="sidebar-link">Matakuliah</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="kelas" class="sidebar-link">
                            <i class="lni lni-clipboard"></i>
                            <span>Kelas</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="jadwal" class="sidebar-link">
                            <i class="lni lni-agenda"></i>
                            <span>Jadwal Perkuliahan</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item">
                        <a href="dashboard_kd" class="sidebar-link">
                            <i class="lni lni-grid-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#auth2" aria-expanded="false" aria-controls="auth2">
                            <i class="lni lni-calendar"></i>
                            <span>Kesediaan Dosen</span>
                        </a>
                        <ul id="auth2" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="dosenwaktu" class="sidebar-link">Waktu</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="dosenmatkul" class="sidebar-link">Matakuliah</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="mahasiswa" class="sidebar-link">
                            <i class="lni lni-graduation"></i>
                            <span>Mahasiswa</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dosen" class="sidebar-link">
                            <i class="lni lni-users"></i>
                            <span>Dosen</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#newMenu" aria-expanded="false" aria-controls="newMenu">
                            <i class="lni lni-chevron-down-circle"></i>
                            <span>Waktu</span>
                        </a>
                        <ul id="newMenu" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="jam" class="sidebar-link">Jam</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="hari" class="sidebar-link">Hari</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="matakuliah" class="sidebar-link">
                            <i class="lni lni-book"></i>
                            <span>Mata Kuliah</span>
                        </a>
                    </li>
                @endif
            </ul>

            <div class="sidebar-footer">
                <a href="logout" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <div class="main p-4 bg-gray">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
