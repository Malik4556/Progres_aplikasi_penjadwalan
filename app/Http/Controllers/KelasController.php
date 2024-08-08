<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $kelas = Kelas::where('id', 'LIKE', '%' . $keyword . '%')
            ->orWhere('angkatan', 'LIKE', '%' . $keyword . '%')
            ->orWhere('kelas', 'LIKE', '%' . $keyword . '%')
            ->orWhere('semester', 'LIKE', '%' . $keyword . '%')
            ->orWhere('jml_mahasiswa', 'LIKE', '%' . $keyword . '%')
            ->get();

        $kelasGenerated = Kelas::count() > 0;

        return view('kelas.kelas', [
            'kelasList' => $kelas,
            'kelasGenerated' => $kelasGenerated,
        ]);
    }

    public function generate(Request $request)
    {
        $mahasiswaList = Mahasiswa::all();
        $kelasList = [];

        foreach ($mahasiswaList as $mahasiswa) {
            $totalMahasiswa = $mahasiswa->jml_mahasiswa;
            $kelasIndex = 0;

            while ($totalMahasiswa > 0) {
                $mahasiswaInClass = min(40, $totalMahasiswa); // Maksimal 40 orang per kelas

                // Mengambil dua digit terakhir dari angkatan
                $angkatan = substr($mahasiswa->angkatan, -2);

                // Membuat nama kelas dengan format angkatan + huruf A-Z
                $kelas = $angkatan . chr(65 + $kelasIndex); // 65 adalah ASCII untuk huruf 'A'

                // Menghindari overflow kelas lebih dari 26 huruf
                if ($kelasIndex >= 26) {
                    break;
                }

                $kelasList[] = [
                    'angkatan' => $mahasiswa->angkatan,
                    'kelas' => $kelas,
                    'semester' => $mahasiswa->semester,
                    'jml_mahasiswa' => $mahasiswaInClass,
                    'mahasiswa_id' => $mahasiswa->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $totalMahasiswa -= $mahasiswaInClass;
                $kelasIndex++;
            }
        }

        // Simpan data ke dalam tabel kelas
        Kelas::insert($kelasList);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function delete($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.kelas-delete', ['kelas' => $kelas]);
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data Kelas berhasil dihapus');
    }

    public function deleteAll()
    {
        // Menghapus semua data dari tabel kelas
        Kelas::query()->delete(); // Perintah ini akan menghapus semua data di tabel kelas

        return redirect()->route('kelas.index')->with('success', 'Semua kelas berhasil dihapus.');
    }

    public function status()
    {
        return view('viewer-status'); // Blade template untuk pihak ketiga
    }
}
