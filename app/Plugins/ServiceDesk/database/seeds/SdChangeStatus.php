<?php

namespace App\Plugins\ServiceDesk\database\seeds;

use DB;
use Illuminate\Database\Seeder;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SdChangeStatus extends Seeder
{
    public function run()
    {
        $created_at = date('Y-d-m H:m:i');
        $updated_at = date('Y-d-m H:m:i');

        DB::table('sd_change_status')
                ->insert(['name' => 'Open',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_status')
                ->insert(['name' => 'Planning',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_status')
                ->insert(['name' => 'Awaiting Approval',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_status')
                ->insert(['name' => 'Pending Release',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_status')
                ->insert(['name' => 'Pending Review',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
        DB::table('sd_change_status')
                ->insert(['name' => 'Closed',
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
        ]);
    }
}
