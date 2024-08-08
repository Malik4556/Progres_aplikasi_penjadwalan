<?php

namespace App\Http\Controllers;

use App\Models\Jam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\JamCreateRequest;

class JamController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $jam = Jam::where('id', 'LIKE', '%' . $keyword . '%')
            ->orWhere('range_jam', 'LIKE', '%' . $keyword . '%')
            ->get();
        return view('jam.jam', ['jamList' => $jam]);
    }

    public function create()
    {
        return view('jam.jam-add');
    }

    public function store(JamCreateRequest $request)
    {
        $range_jam = $request->jam_mulai . ' - ' . $request->jam_selesai;

        $jam = Jam::create([
            'range_jam' => $range_jam,
        ]);

        if ($jam) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Jam Berhasil Ditambahkan');
        }

        return redirect('/jam');
    }

    public function edit($id)
    {
        $jam =  Jam::findOrFail($id);
        return view('jam.jam-edit', ['jam' => $jam]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ]);

        $jam = Jam::findOrFail($id);

        // Gabungkan waktu mulai dan selesai
        $range_jam = $request->jam_mulai . ' - ' . $request->jam_selesai;

        // Update data
        $jam->update([
            'range_jam' => $range_jam,
        ]);

        if ($jam) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Jam Berhasil Dirubah');
        }

        return redirect('/jam');
    }

    public function delete($id)
    {
        $jam = Jam::findOrFail($id);
        return view('jam.jam-delete', ['jam' => $jam]);
    }

    public function destroy(Request $request, $id)
    {
        $deletedjam = Jam::findOrFail($id);
        $deletedjam->delete();
        if ($deletedjam) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Jam Berhasil Dihapus');
        }
        return redirect('/jam');
    }
}
