<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $banks = [
            ['nama' => 'BCA', 'logo_filename' => 'bca.png'],
            ['nama' => 'BNI', 'logo_filename' => 'bni.png'],
            ['nama' => 'BRI', 'logo_filename' => 'bri.png'],
            ['nama' => 'Mandiri', 'logo_filename' => 'mandiri.png'],
            ['nama' => 'BSI', 'logo_filename' => 'bsi.png'],
            ['nama' => 'CIMB Niaga', 'logo_filename' => 'cimb_niaga.png'],
            ['nama' => 'Permata', 'logo_filename' => 'permata.png'],
        ];

        DB::table('banks')->insert($banks);
    }
}
