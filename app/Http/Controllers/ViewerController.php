<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\StatusProses;
use App\Models\StatusDosenWaktu;
use App\Models\StatusDosenMatkul;
use App\Models\DosenWaktu;
use App\Models\DosenMatkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ViewerController extends Controller
{
    public function mahasiswa(Request $request)
    {
        $keyword = $request->keyword;
        $mahasiswa = Mahasiswa::where('id', 'LIKE', '%' . $keyword . '%')
            ->orWhere('angkatan', 'LIKE', '%' . $keyword . '%')
            ->orWhere('semester', 'LIKE', '%' . $keyword . '%')
            ->orWhere('jml_mahasiswa', 'LIKE', '%' . $keyword . '%')
            ->get();

        $statusProses = StatusProses::first();
        $status = $statusProses ? $statusProses->status : false;

        return view('viewer.viewer-mahasiswa', [
            'mahasiswaList' => $mahasiswa,
            'status' => $status
        ]);
    }

    public function dosenwaktu(Request $request)
    {
        $keyword = $request->keyword;
        $dosenwaktu = DosenWaktu::join('dosens', 'dosen_waktus.dosen_id', '=', 'dosens.id')
            ->join('haris', 'dosen_waktus.hari_id', '=', 'haris.id')
            ->join('jams', 'dosen_waktus.jam_id', '=', 'jams.id')
            ->where(function ($query) use ($keyword) {
                $query->where('dosens.nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('haris.hari', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('jams.range_jam', 'LIKE', '%' . $keyword . '%');
            })
            ->orderBy('dosens.nama', 'asc')
            ->orderBy('haris.id', 'asc')
            ->orderBy('jams.range_jam', 'asc')
            ->select('dosen_waktus.*')
            ->get();

            $statusProsesDoswak = StatusDosenWaktu::first();
            $statusdoswak = $statusProsesDoswak ? $statusProsesDoswak->status : false;

        return view('viewer.viewer-dosenwaktu', [
            'dosenwaktuList' => $dosenwaktu,
            'statusdoswak' => $statusdoswak
        ]);
    }

    public function dosenmatkul(Request $request)
    {
        $keyword = $request->keyword;
        $dosenmatkul = DosenMatkul::join('dosens', 'dosen_matkuls.dosen_id', '=', 'dosens.id')
            ->join('matakuliahs', 'dosen_matkuls.matakuliah_id', '=', 'matakuliahs.id')
            ->where(function ($query) use ($keyword) {
                $query->where('dosens.nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('matakuliahs.nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('dosen_matkuls.semester', 'LIKE', '%' . $keyword . '%');
            })
            ->orderBy('dosens.nama', 'asc')
            ->orderBy('dosen_matkuls.semester', 'asc')
            ->orderBy('matakuliahs.nama', 'asc')
            ->select('dosen_matkuls.*')
            ->get();

            $statusProsesDoskul = StatusDosenMatkul::first();
            $statusdoskul = $statusProsesDoskul ? $statusProsesDoskul->status : false;

        return view('viewer.viewer-dosenmatkul', [
            'dosenmatkulList' => $dosenmatkul,
            'statusdoskul' => $statusdoskul
        ]);
    }

    public function updateStatus(Request $request)
    {
        $status = $request->input('completed') === 'true';
        Session::put('status_proses', $status);

        return response()->json(['status' => $status]);
    }

    public function updateStatusDoswak(Request $request)
    {
        $statusdoswak = $request->input('completed') === 'true';
        Session::put('status_dosen_waktus', $statusdoswak);

        return response()->json(['statusdoswak' => $statusdoswak]);
    }

    public function updateStatusDoskul(Request $request)
    {
        $statusdoskul = $request->input('completed') === 'true';
        Session::put('status_dosen_matkul', $statusdoskul);

        return response()->json(['statusdoskul' => $statusdoskul]);
    }
}
