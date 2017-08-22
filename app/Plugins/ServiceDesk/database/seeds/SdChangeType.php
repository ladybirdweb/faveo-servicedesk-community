<?php

namespace App\Plugins\ServiceDesk\database\seeds;

use DB;
use Illuminate\Database\Seeder;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SdChangeType extends Seeder
{
    public function run()
    {
        $created_at = date('Y-d-m H:m:i');
        $updated_at = date('Y-d-m H:m:i');

        DB::table('sd_change_types')
                ->insert(['name' => 'Minor',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_types')
                ->insert(['name' => 'Standard',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_types')
                ->insert(['name' => 'Major',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_types')
                ->insert(['name' => 'Emergency',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
    }
}
