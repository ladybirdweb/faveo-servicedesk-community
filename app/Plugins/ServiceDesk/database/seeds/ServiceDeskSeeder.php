<?php
namespace App\Plugins\ServiceDesk\database\seeds;
use App\Plugins\ServiceDesk\database\seeds\SdAssetTypeSeeder;
use App\Plugins\ServiceDesk\database\seeds\SdImpactSeeder;
use App\Plugins\ServiceDesk\database\seeds\SdProductProcMode;
use App\Plugins\ServiceDesk\database\seeds\SdLocationCategorySeeder;
use App\Plugins\ServiceDesk\database\seeds\SdAssetAttachmentTypes;
use App\Plugins\ServiceDesk\database\seeds\SdContractTypes;
use App\Plugins\ServiceDesk\database\seeds\SdLicenseTypes;
use App\Plugins\ServiceDesk\database\seeds\SdChangePriority;
use App\Plugins\ServiceDesk\database\seeds\SdChangeStatus;
use App\Plugins\ServiceDesk\database\seeds\SdChangeType;
use App\Plugins\ServiceDesk\database\seeds\SdReleasePriority;
use App\Plugins\ServiceDesk\database\seeds\SdReleaseStatus;
use App\Plugins\ServiceDesk\database\seeds\SdReleaseType;
use App\Plugins\ServiceDesk\database\seeds\SdProductStatus;
use Illuminate\Database\Seeder;

class ServiceDeskSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        

        $seed = new SdAssetTypeSeeder();
        $seed->run();

        $seed1 = new SdImpactSeeder();
        $seed1->run();

        $seed2 = new SdLocationCategorySeeder();
        $seed2->run();

        $seed3 = new SdAssetAttachmentTypes();
        $seed3->run();

        $seed4 = new SdContractTypes();
        $seed4->run();

        $seed5 = new SdLicenseTypes();
        $seed5->run();

        $seed6 = new SdLicenseTypes();
        $seed6->run();
        
        $seed7 = new SdProductProcMode();
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
        
        $seed14 = new SdProductStatus();
        $seed14->run();
    }

}

