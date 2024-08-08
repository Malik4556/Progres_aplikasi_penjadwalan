<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\StatusProses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\MahasiswaCreateRequest;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $mahasiswa = Mahasiswa::where('id', 'LIKE', '%' . $keyword . '%')
            ->orWhere('angkatan', 'LIKE', '%' . $keyword . '%')
            ->orWhere('semester', 'LIKE', '%' . $keyword . '%')
            ->orWhere('jml_mahasiswa', 'LIKE', '%' . $keyword . '%')
            ->get();

        $statusProses = StatusProses::first();
        $status = $statusProses ? $statusProses->status : false;

        return view('mahasiswa.mahasiswa', [
            'mahasiswaList' => $mahasiswa,
            'status' => $status
        ]);
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::select('id', 'angkatan', 'semester', 'jml_mahasiswa')->get();
        return view('mahasiswa.mahasiswa-add', ['mahasiswa' => $mahasiswa]);
    }

    public function store(MahasiswaCreateRequest $request)
    {
        $mahasiswa = Mahasiswa::create($request->all());

        if ($mahasiswa) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Mahasiswa Berhasil Ditambahkan');
        }
        return redirect('/mahasiswa');
    }

    public function edit(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('mahasiswa.mahasiswa-edit', ['mahasiswa' => $mahasiswa]);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        if ($mahasiswa) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Mahasiswa Berhasil Dirubah');
        }

        return redirect('/mahasiswa');
    }

    public function delete($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('mahasiswa.mahasiswa-delete', ['mahasiswa' => $mahasiswa]);
    }

    public function destroy(Request $request, $id)
    {
        $deletedmahasiswa = Mahasiswa::findOrFail($id);
        $deletedmahasiswa->delete();
        if ($deletedmahasiswa) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Jumlah angkatan Berhasil Dihapus');
        }
        return redirect('/mahasiswa');
    }

    public function updateStatus(Request $request)
    {
        $statusProses = StatusProses::first();
        if (!$statusProses) {
            $statusProses = new StatusProses();
        }

        $statusProses->status = !$statusProses->status;
        $statusProses->save();

        return response()->json(['status' => $statusProses->status]);
    }

    public function status()
    {
        $statusProses = StatusProses::first();
        $status = $statusProses ? $statusProses->status : false;

        return view('status', compact('status'));
    }
}
