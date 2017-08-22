<?php

namespace App\Plugins\ServiceDesk\Controllers;

use App\Http\Controllers\Controller;
use App\Plugins\ServiceDesk\database\seeds\ServiceDeskSeeder;
use Artisan;
use Exception;
use Schema;

class ActivateController extends Controller
{
    public function activate()
    {
        try {
            if (!Schema::hasTable('sd_assets')) {
                $this->migrate();
                $this->seed();
            }
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function publish()
    {
        try {
            $publish = 'vendor:publish';
            $provider = 'App\Plugins\ServiceDesk\ServiceProvider';
            $tag = 'migrations';
            $r = Artisan::call($publish, ['--provider' => $provider, '--tag' => [$tag]]);
            //dd($r);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function migrate()
    {
        try {
            $path = 'app'.DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'ServiceDesk'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
            Artisan::call('migrate', [
            '--path' => $path,
            '--force'=> true,
            ]);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function seed()
    {
        try {
            $controller = new ServiceDeskSeeder();
            $controller->run();

            return 1;
        } catch (Exception $ex) {
            dd($ex);
        }
    }
}
