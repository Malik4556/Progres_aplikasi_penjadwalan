<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateSksInDosenMatkuls extends Command
{
    protected $signature = 'update:sks-dosen-matkuls';
    protected $description = 'Update SKS in dosen_matkuls table based on matakuliahs table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('dosen_matkuls')
            ->join('matakuliahs', 'dosen_matkuls.matakuliah_id', '=', 'matakuliahs.id')
            ->update(['dosen_matkuls.sks' => DB::raw('matakuliahs.sks')]);

        $this->info('SKS updated successfully in dosen_matkuls table.');
    }
}
