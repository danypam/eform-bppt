<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class eformCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eform:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function cronUnitJabatan(){
        $sidadu = DB::table('eform_sidadu.unitjabatan')->get();
        foreach ($sidadu as $s){
            DB::table('unit_jabatan')
                ->updateOrInsert(
                    ['id_unit_jabatan' => $s->kode_unit],
                    [   'unit' => $s->unit,
                        'kode_unitatas1' => $s->kode_unitatas1,
                        'kode_unitatas2' => $s->kode_unitatas2,
                        'singkat' => $s->singkatan,
                        'is_unit' => $s->is_unit,
                        'is_deputi' => $s->is_deputi,
                        'is_kabppt' => $s->is_kabppt
                    ]
                );
        }


    }

    public function cronJabatan(){
        $sidadu = DB::table('eform_sidadu.jabatan')->get();
        foreach ($sidadu as $s){
            DB::table('jabatan')
                ->updateOrInsert(
                    ['id' => $s->kode_jabatan],
                    [   'nama_jabatan' => $s->nama_jabatan,
                        'eselon' => $s->eselon
                    ]
                );
        }
    }

    public function cronPegawai(){
        $sidadu = DB::table('eform_sidadu.pegawai')
            ->join('eform_sidadu.unitjabatan as uj','unit_jabatan_id','uj.kode_unit')->get();
        foreach ($sidadu as $s){
            //cek isdeputi/isunit/iskabppt
            $role = ($s->is_unit == 1 || $s->is_deputi == 1 || $s->is_kabppt == 1) ? 'atasan' : 'member';
            \Log::info("role is " . $role);
            DB::table('pegawai')
                ->updateOrInsert(
                    ['nip' => $s->nip],
                    [   'nip18' => $s->nip18,
                        'nama_lengkap' => $s->nama_lengkap,
                        'unit_id' => $s->kode_unitkerja,
                        'unit_jabatan_id' => $s->kode_unit,
                        'jabatan_id' => $s->kode_jabatan,
                        'nip_atas' => $s->nip_atas,
                        'role' => $role,
                        'email' => $s->username . '@bppt.go.id'
                    ]
                    //role -> isunit,isdeputi,iskabppt = atasan
                    //role -> !(isunit,isdeputi,iskabppt) = member
                    //email -> sidadu
                    //
                );
        }
    }
    public function handle()
    {
        //
        \Log::info("Working on Update");

        $this->cronUnitJabatan();
        $this->cronJabatan();
        $this->cronPegawai();

        \Log::info("Database Updated");
        $this->info('Demo:Cron Cummand Run successfully!');
    }
}
