<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        DB::table('absensi')->insert([
            [
                'sn' => '61629016310175',
                'scan_date' => '2020-09-15 10:00:39',
                'pin' => 1231,
                'verifymode' => 1,
                'inoutmode' => 4,
                'reserved' => 0,
                'work_code' => 0,
                'att_id' => '150920200000000000000000000000000'
            ],
            [
                'sn' => '61629016310175',
                'scan_date' => '2020-09-15 10:00:42',
                'pin' => 995,
                'verifymode' => 1,
                'inoutmode' => 4,
                'reserved' => 0,
                'work_code' => 0,
                'att_id' => '15092020000000000000000000000000'
            ],
            [
                'sn' => '61629016310175',
                'scan_date' => '2020-09-15 10:00:44',
                'pin' => 602,
                'verifymode' => 1,
                'inoutmode' => 4,
                'reserved' => 0,
                'work_code' => 0,
                'att_id' => '15092020000000000000000000000000'
            ],
            [
                'sn' => '61629016310175',
                'scan_date' => '2020-09-15 10:00:48',
                'pin' => 104,
                'verifymode' => 1,
                'inoutmode' => 4,
                'reserved' => 0,
                'work_code' => 0,
                'att_id' => '15092020000000000000000000000000'
            ],
            [
                'sn' => '61629016310175',
                'scan_date' => '2020-09-15 10:00:51',
                'pin' => 1787,
                'verifymode' => 1,
                'inoutmode' => 4,
                'reserved' => 0,
                'work_code' => 0,
                'att_id' => '150920200000000000000000000000000'
            ],
            // Add more records as needed
        ]);
    }
}
