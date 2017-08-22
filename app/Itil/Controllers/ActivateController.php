<?php

namespace App\Itil\Controllers;

use App\Http\Controllers\Controller;
use App\Itil\database\seeds\ServiceDeskSeeder;
use Artisan;
use Exception;

class ActivateController extends Controller
{
    public function activate()
    {
        try {
            if (isItil() == false) {
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
            $provider = 'App\Itil\ItilServiceProvider';
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
            $path = 'app'.DIRECTORY_SEPARATOR.'Itil'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';
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
