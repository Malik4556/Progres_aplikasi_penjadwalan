<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jam;
use App\Models\Hari;
use App\Models\DosenWaktu;
use App\Models\StatusDosenWaktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\DosenWaktuCreateRequest;

class DosenWaktuController extends Controller
{

    public function index(Request $request)
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

        return view('dosenwaktu.dosenwaktu', [
            'dosenwaktuList' => $dosenwaktu,
            'statusdoswak' => $statusdoswak
        ]);
    }

    public function create()
    {

        $dosens = Dosen::select('id', 'nama')->orderBy('nama', 'asc')->get();
        $haris = Hari::select('id', 'hari')->orderBy('id', 'asc')->get();
        $jams = Jam::select('id', 'range_jam')->orderBy('range_jam', 'asc')->get();

        return view('dosenwaktu.dosenwaktu-add', compact('dosens', 'haris', 'jams'));
    }

    public function store(DosenWaktuCreateRequest $request)
    {
        $validatedData = $request->validated();

        $dosenwaktu = DosenWaktu::create([
            'dosen_id' => $validatedData['dosen_id'],
            'hari_id' => $validatedData['hari_id'],
            'jam_id' => $validatedData['jam_id'],
        ]);

        if ($dosenwaktu) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen dan Waktu Berhasil Ditambahkan');
        }

        return redirect('/dosenwaktu');
    }

    public function edit($id)
    {
        $dosenwaktu = DosenWaktu::findOrFail($id);
        $dosens = Dosen::select('id', 'nama')->orderBy('nama', 'asc')->get();
        $haris = Hari::select('id', 'hari')->orderBy('id', 'asc')->get();
        $jams = Jam::select('id', 'range_jam')->orderBy('range_jam', 'asc')->get();


        return view('dosenwaktu.dosenwaktu-edit', compact('dosenwaktu', 'dosens', 'haris', 'jams'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'dosen_id' => 'required',
            'hari_id' => 'required',
            'jam_id' => 'required',
        ]);

        $dosenwaktu = DosenWaktu::findOrFail($id);
        $dosenwaktu->update($validatedData);

        if ($dosenwaktu) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen dan Waktu Berhasil Dirubah');
        }

        return redirect('/dosenwaktu');
    }

    public function delete($id)
    {
        $dosenwaktu = DosenWaktu::findOrFail($id);
        $dosen = Dosen::findOrFail($dosenwaktu->dosen_id);

        return view('dosenwaktu.dosenwaktu-delete', ['dosenwaktu' => $dosenwaktu, 'dosen' => $dosen]);
    }

    public function destroy($id)
    {
        $deleteddosenwaktu = DosenWaktu::findOrFail($id);
        $deleteddosenwaktu->delete();

        if ($deleteddosenwaktu) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen dan Waktu Berhasil Dihapus');
        }

        return redirect('/dosenwaktu');
    }

    public function updateStatusDoswak(Request $request)
    {
        $statusProsesDoswak = StatusDosenWaktu::first();
        if (!$statusProsesDoswak) {
            $statusProsesDoswak = new StatusDosenWaktu();
        }

        $statusProsesDoswak->status = !$statusProsesDoswak->status;
        $statusProsesDoswak->save();

        return response()->json(['statusdoswak' => $statusProsesDoswak->status]);
    }

    public function statusdoswak()
    {
        $statusProsesDoswak = StatusDosenWaktu::first();
        $statusdoswak = $statusProsesDoswak ? $statusProsesDoswak->status : false;

        return view('statusdoswak', compact('statusdoswak'));
    }
}
