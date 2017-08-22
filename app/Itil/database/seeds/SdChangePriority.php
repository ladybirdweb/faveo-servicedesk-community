<?php

namespace App\Itil\database\seeds;

use DB;
use Illuminate\Database\Seeder;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SdChangePriority extends Seeder
{
    public function run()
    {
        $created_at = date('Y-d-m H:m:i');
        $updated_at = date('Y-d-m H:m:i');

        DB::table('sd_change_priorities')
                ->insert(['name' => 'Low',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_priorities')
                ->insert(['name' => 'Medium',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_priorities')
                ->insert(['name' => 'High',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_priorities')
                ->insert(['name' => 'Urgent',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
    }
}
