<?php
namespace App\Itil\Database\seeds;
use App\Itil\Database\seeds\SdChangePriority;
use App\Itil\Database\seeds\SdChangeStatus;
use App\Itil\Database\seeds\SdChangeType;
use App\Itil\Database\seeds\SdReleasePriority;
use App\Itil\Database\seeds\SdReleaseStatus;
use App\Itil\Database\seeds\SdReleaseType;
use App\Itil\database\seeds\SdAssetAttachmentTypes;
use Illuminate\Database\Seeder;

class ServiceDeskSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $seed7 = new SdAssetAttachmentTypes();
        $seed7->run();
        
        $seed8 = new SdChangePriority();
        $seed8->run();
        
        $seed9 = new SdChangeType();
        $seed9->run();
        
        $seed10 = new SdChangeStatus();
        $seed10->run();
        
        $seed11 = new SdReleasePriority();
        $seed11->run();
        
        $seed12 = new SdReleaseStatus();
        $seed12->run();
        
        $seed13 = new SdReleaseType();
        $seed13->run();
        
        
    }

}

