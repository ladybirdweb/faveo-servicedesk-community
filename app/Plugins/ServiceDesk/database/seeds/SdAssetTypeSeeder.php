<?php

namespace App\Plugins\ServiceDesk\database\seeds;

use DB;
use Illuminate\Database\Seeder;

class SdAssetTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [['name' => 'Services', 'parent_id' => ''],
            ['name' => 'Cloud', 'parent_id' => ''],
            ['name' => 'Hardware', 'parent_id' => ''],
            ['name' => 'Software', 'parent_id' => ''],
            ['name' => 'Consumable', 'parent_id' => ''],
            ['name' => 'Network', 'parent_id' => ''],
            ['name' => 'Document', 'parent_id' => ''],
            ['name' => 'Others', 'parent_id' => ''],
            ['name' => 'Business Service', 'parent_id' => 1],
            ['name' => 'IT Service', 'parent_id' => 1],
            ['name' => 'Sales Service', 'parent_id' => 9],
            ['name' => 'Support Service', 'parent_id' => 9],
            ['name' => 'Email service', 'parent_id' => 10],
            ['name' => 'Backup service', 'parent_id' => 10],
            ['name' => 'Hosting service', 'parent_id' => 10],
            ['name' => 'AWS', 'parent_id' => 2],
            ['name' => 'EC2', 'parent_id' => 16],
            ['name' => 'RDS', 'parent_id' => 16],
            ['name' => 'EBS', 'parent_id' => 16],
            ['name' => 'Computer', 'parent_id' => 3],
            ['name' => 'Storage', 'parent_id' => 3],
            ['name' => 'Data Center', 'parent_id' => 3],
            ['name' => 'Mobile Devices', 'parent_id' => 3],
            ['name' => 'Monitor', 'parent_id' => 3],
            ['name' => 'Printer', 'parent_id' => 3],
            ['name' => 'Projector', 'parent_id' => 3],
            ['name' => 'Scanner', 'parent_id' => 3],
            ['name' => 'Router', 'parent_id' => 3],
            ['name' => 'Switch', 'parent_id' => 3],
            ['name' => 'Access Point', 'parent_id' => 3],
            ['name' => 'Firewall', 'parent_id' => 3],
            ['name' => 'Other Devices', 'parent_id' => 3],
            ['name' => 'Desktop', 'parent_id' => 20],
            ['name' => 'Laptop', 'parent_id' => 20],
            ['name' => 'Server', 'parent_id' => 20],
            ['name' => 'Unix Server', 'parent_id' => 35],
            ['name' => 'Solaris Server', 'parent_id' => 35],
            ['name' => 'Aix Server', 'parent_id' => 35],
            ['name' => 'VMwareServer', 'parent_id' => 35],
            ['name' => 'Windows Server', 'parent_id' => 35],
            ['name' => 'Disk', 'parent_id' => 21],
        ];
        //dd(count($types));
        for ($i = 0; $i < count($types); $i++) {
            $n = $i + 1;
            $created_at = date('Y-d-m H:m:i');
            $updated_at = date('Y-d-m H:m:i');
            if ($types[$i]) {
                DB::table('sd_asset_types')->insert(['id' => $n, 'name' => $types[$i]['name'], 'parent_id' => $types[$i]['parent_id'],
                    'created_at'                          => $created_at, 'updated_at' => $updated_at,
                ]);
            }
        }
    }
}
