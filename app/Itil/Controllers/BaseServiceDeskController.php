<?php

namespace App\Itil\Controllers;

use App\Http\Controllers\Controller;

class BaseServiceDeskController extends Controller
{
    public function __construct()
    {
        \Event::fire('service.desk.activate', []);
    }
}
