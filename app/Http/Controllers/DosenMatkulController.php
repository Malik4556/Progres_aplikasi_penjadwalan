<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\DosenMatkul;
use App\Models\StatusDosenMatkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\DosenMatkulCreateRequest;

class DosenMatkulController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $dosenmatkul = DosenMatkul::join('dosens', 'dosen_matkuls.dosen_id', '=', 'dosens.id')
            ->join('matakuliahs', 'dosen_matkuls.matakuliah_id', '=', 'matakuliahs.id')
            ->where(function ($query) use ($keyword) {
                $query->where('dosens.nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('matakuliahs.nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('dosen_matkuls.semester', 'LIKE', '%' . $keyword . '%');
            })
            ->orderBy('dosens.nama', 'asc')  // Urutkan berdasarkan nama dosen
            ->orderBy('dosen_matkuls.semester', 'asc')  // Urutkan berdasarkan semester
            ->orderBy('matakuliahs.nama', 'asc')  // Urutkan berdasarkan matakuliah
            ->select('dosen_matkuls.*', 'matakuliahs.sks') // Pilih kolom dari dosen_matkuls
            // ->paginate(6);
            ->get();

        $statusProsesDoskul = StatusDosenMatkul::first();
        $statusdoskul = $statusProsesDoskul ? $statusProsesDoskul->status : false;

        return view('dosenmatkul.dosenmatkul', [
            'dosenmatkulList' => $dosenmatkul,
            'statusdoskul' => $statusdoskul
        ]);
    }

    public function create()
    {
        $dosens = Dosen::select('id', 'nama')->orderBy('nama', 'asc')->get();
        $semesters = Matakuliah::select('semester')->distinct()->orderBy('semester', 'asc')->pluck('semester');
        $matakuliahs = Matakuliah::select('id', 'nama', 'semester')->orderBy('nama', 'asc')->get();

        return view('dosenmatkul.dosenmatkul-add', compact('dosens', 'semesters', 'matakuliahs'));
    }

    public function getMatakuliahBySemester(Request $request)
    {
        $semester = $request->semester;
        $matakuliahs = Matakuliah::where('semester', $semester)->orderBy('nama', 'asc')->get();
        return response()->json($matakuliahs);
    }

    public function getSksByMatakuliah(Request $request)
    {
        $matakuliah_id = $request->matakuliah_id;
        $matakuliah = Matakuliah::find($matakuliah_id);

        if ($matakuliah) {
            return response()->json(['sks' => $matakuliah->sks]);
        } else {
            return response()->json(['sks' => '']);
        }
    }

    public function store(DosenMatkulCreateRequest $request)
    {
        $validatedData = $request->validated();

        $matakuliah = Matakuliah::find($validatedData['matakuliah_id']);
        $sks = $matakuliah ? $matakuliah->sks : null;

        $dosenmatkul = DosenMatkul::create([
            'dosen_id' => $validatedData['dosen_id'],
            'matakuliah_id' => $validatedData['matakuliah_id'],
            'semester' => $validatedData['semester'],
            'sks' => $sks, // Menyimpan SKS yang diambil dari Matakuliah
        ]);

        if ($dosenmatkul) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen dan Matakuliah Berhasil Ditambahkan');
        }

        return redirect('/dosenmatkul');
    }


    public function edit($id)
    {
        $dosenmatkul = DosenMatkul::findOrFail($id);
        $dosens = Dosen::select('id', 'nama')->orderBy('nama', 'asc')->get();
        $semesters = Matakuliah::select('semester')->distinct()->orderBy('semester', 'asc')->pluck('semester');
        $matakuliahs = Matakuliah::select('id', 'nama')->orderBy('nama', 'asc')->get();

        return view('dosenmatkul.dosenmatkul-edit', compact('dosenmatkul', 'dosens', 'matakuliahs', 'semesters'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'dosen_id' => 'required',
            'matakuliah_id' => 'required',
            'semester' => 'required',
        ]);

        $matakuliah = Matakuliah::find($validatedData['matakuliah_id']);
        $sks = $matakuliah ? $matakuliah->sks : null;

        $dosenmatkul = DosenMatkul::findOrFail($id);
        $dosenmatkul->update([
            'dosen_id' => $validatedData['dosen_id'],
            'matakuliah_id' => $validatedData['matakuliah_id'],
            'semester' => $validatedData['semester'],
            'sks' => $sks, // Memperbarui SKS yang diambil dari Matakuliah
        ]);

        if ($dosenmatkul) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen dan Matakuliah Berhasil Dirubah');
        }

        return redirect('/dosenmatkul');
    }


    public function delete($id)
    {
        $dosenmatkul = DosenMatkul::findOrFail($id);
        $dosen = Dosen::findOrFail($dosenmatkul->dosen_id);

        return view('dosenmatkul.dosenmatkul-delete', ['dosenmatkul' => $dosenmatkul, 'dosen' => $dosen]);
    }

    public function destroy($id)
    {
        $deletedDosenMatkul = DosenMatkul::findOrFail($id);
        $deletedDosenMatkul->delete();

        if ($deletedDosenMatkul) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen dan Matakuliah Berhasil Dihapus');
        }

        return redirect('/dosenmatkul');
    }

    public function updateStatusDoskul(Request $request)
    {
        $statusProsesDoskul = StatusDosenMatkul::first();
        if (!$statusProsesDoskul) {
            $statusProsesDoskul = new StatusDosenMatkul();
        }

        $statusProsesDoskul->status = !$statusProsesDoskul->status;
        $statusProsesDoskul->save();

        return response()->json(['statusdoskul' => $statusProsesDoskul->status]);
    }

    public function statusdoskul()
    {
        $statusProsesDoskul = StatusDosenMatkul::first();
        $statusdoskul = $statusProsesDoskul ? $statusProsesDoskul->status : false;

        return view('statusdoskul', compact('statusdoskul'));
    }
}
