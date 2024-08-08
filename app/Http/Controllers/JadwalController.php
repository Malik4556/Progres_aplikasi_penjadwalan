<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\DosenMatkul;
use App\Models\DosenWaktu;
use App\Models\Ruangan;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $jadwal = Jadwal::join('dosen_waktus', 'jadwals.dosen_waktu_id', '=', 'dosen_waktus.id')
            ->join('jams', 'dosen_waktus.jam_id', '=', 'jams.id')
            ->join('dosens', 'dosen_waktus.dosen_id', '=', 'dosens.id')
            ->join('haris', 'dosen_waktus.hari_id', '=', 'haris.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('dosen_matkuls', 'jadwals.dosen_matkul_id', '=', 'dosen_matkuls.id')
            ->join('matakuliahs', 'dosen_matkuls.matakuliah_id', '=', 'matakuliahs.id')
            ->join('ruangans', 'jadwals.ruangan_id', '=', 'ruangans.id')
            ->where(function ($query) use ($keyword) {
                $query->where('dosens.nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('haris.hari', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('kelas.kelas', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('matakuliahs.nama', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('ruangans.no_ruangan', 'LIKE', '%' . $keyword . '%');
            })
            ->select(
                'jadwals.id',
                'jadwals.kelas_id',
                'jadwals.dosen_matkul_id',
                'jadwals.ruangan_id',
                DB::raw("SUBSTRING_INDEX(jams.range_jam, ' - ', 1) as jam_mulai"),
                DB::raw("SUBSTRING_INDEX(jams.range_jam, ' - ', -1) as jam_selesai"),
                'dosens.nama as nama_dosen',
                'haris.hari as hari',
                'kelas.kelas as nama_kelas',
                'matakuliahs.nama as nama_matakuliah',
                'dosen_matkuls.sks as sks',
                'ruangans.no_ruangan as no_ruangan'
            )
            ->get();

        return view('jadwal.jadwal', ['jadwalList' => $jadwal]);
    }

    public function generate()
    {
        $classes = Kelas::all();
        $time_slots = $this->getAvailableTimeSlots();
        $schedule = $this->initializeScheduleMatrix($classes, $time_slots);

        if ($this->backtrack($schedule, $time_slots, $classes)) {
            $this->saveSchedule($schedule);
            return response()->json(['status' => 'success', 'message' => 'Jadwal berhasil dibuat']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Tidak ditemukan jadwal yang valid']);
        }
    }

    private function initializeScheduleMatrix($classes, $time_slots)
    {
        $schedule = [];

        foreach ($classes as $class) {
            $schedule[$class->id] = array_fill(0, count($time_slots), null);
        }

        return $schedule;
    }

    private function getAvailableTimeSlots()
    {
        return [
            '08:00 - 08:40',
            '08:40 - 09:20',
            '09:20 - 10:00',
            '10:00 - 10:40',
            '10:40 - 11:20',
            '11:20 - 12:00',
            '13:00 - 13:40',
            '13:40 - 14:20',
            '14:20 - 15:00',
            '15:00 - 15:40',
            '15:40 - 16:20',
            '16:20 - 17:00',
        ];
    }

    private function isSafeToSchedule($class, $currentSlot, $schedule, $sks)
    {
        $slotDuration = 40; // 1 SKS = 40 menit
        $requiredSlots = ceil(($sks * 40) / $slotDuration); // Hitung slot yang diperlukan berdasarkan SKS

        for ($i = 0; $i < $requiredSlots; $i++) {
            if (!isset($schedule[$class->id][$currentSlot + $i]) || $schedule[$class->id][$currentSlot + $i] !== null) {
                return false;
            }
        }

        return $this->isRoomAvailable($currentSlot, $requiredSlots) && $this->isDosenAvailable($class, $currentSlot, $requiredSlots);
    }


    private function isRoomAvailable($currentSlot, $requiredSlots)
    {
        $rooms = Ruangan::all();
        $timeSlots = $this->getAvailableTimeSlots();

        foreach ($rooms as $room) {
            $isAvailable = true;
            for ($i = 0; $i < $requiredSlots; $i++) {
                $timeSlotRange = explode(' - ', $timeSlots[$currentSlot + $i]);
                $isRoomScheduled = Jadwal::where('ruangan_id', $room->id)
                    ->whereBetween('jam_mulai', [$timeSlotRange[0], $timeSlotRange[1]])
                    ->exists();

                if ($isRoomScheduled) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                return true;
            }
        }

        return false;
    }

    private function isDosenAvailable($class, $currentSlot, $requiredSlots)
    {
        $dosenMatkul = DosenMatkul::find($class->dosen_matkul_id);

        if ($dosenMatkul === null) {
            return false;
        }

        $dosenWaktu = DosenWaktu::where('dosen_id', $dosenMatkul->dosen_id)->get();
        $timeSlots = $this->getAvailableTimeSlots();

        foreach ($dosenWaktu as $dw) {
            $isAvailable = true;
            for ($i = 0; $i < $requiredSlots; $i++) {
                $timeSlotRange = explode(' - ', $timeSlots[$currentSlot + $i]);
                if (!($dw->jam_mulai <= $timeSlotRange[0] && $dw->jam_selesai >= $timeSlotRange[1])) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                return true;
            }
        }

        return false;
    }

     private function backtrack(&$schedule, $time_slots, $classes, $currentSlot = 0)
    {
        if ($currentSlot >= count($time_slots)) {
            return true;
        }

        foreach ($classes as $class) {
            $dosenMatkul = DosenMatkul::find($class->dosen_matkul_id);

            if ($dosenMatkul && $this->isSafeToSchedule($class, $currentSlot, $schedule, $dosenMatkul->sks)) {
                $schedule[$class->id][$currentSlot] = $dosenMatkul->id;

                if ($this->backtrack($schedule, $time_slots, $classes, $currentSlot + 1)) {
                    return true;
                }

                $schedule[$class->id][$currentSlot] = null;
            }
        }

        return false;
    }

    private function saveSchedule($schedule)
    {
        foreach ($schedule as $classId => $slots) {
            foreach ($slots as $slot => $dosenMatkulId) {
                if ($dosenMatkulId !== null) {
                    $dosenMatkul = DosenMatkul::find($dosenMatkulId);

                    if ($dosenMatkul) {
                        Jadwal::create([
                            'kelas_id' => $classId,
                            'dosen_matkul_id' => $dosenMatkulId,
                            'jam_mulai' => $this->getTimeSlotStart($slot),
                            'jam_selesai' => $this->getTimeSlotEnd($slot),
                            'ruangan_id' => $this->getAvailableRoom($slot),
                            'semester' => Kelas::find($classId)->semester,
                            'dosen_waktu_id' => DosenWaktu::where('dosen_id', $dosenMatkul->dosen_id)->first()->id,
                        ]);
                    }
                }
            }
        }
    }

    private function getTimeSlotStart($slot)
    {
        $timeSlots = $this->getAvailableTimeSlots();
        return explode(' - ', $timeSlots[$slot])[0];
    }

    private function getTimeSlotEnd($slot)
    {
        $timeSlots = $this->getAvailableTimeSlots();
        return explode(' - ', $timeSlots[$slot])[1];
    }

    private function getAvailableRoom($currentSlot)
    {
        $rooms = Ruangan::all();
        $timeSlots = $this->getAvailableTimeSlots();

        foreach ($rooms as $room) {
            $isAvailable = true;
            $timeSlotRange = explode(' - ', $timeSlots[$currentSlot]);
            $isRoomScheduled = Jadwal::where('ruangan_id', $room->id)
                ->whereBetween('jam_mulai', [$timeSlotRange[0], $timeSlotRange[1]])
                ->exists();

            if (!$isRoomScheduled) {
                return $room->id;
            }
        }

        return null;
    }
}
