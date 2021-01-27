<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function execute() {

        if(view()->exists('admin.services')) {
            $services = Service::all();
            $data = [
                'title'=>'Сервисы',
                'services'=>$services
            ];
            return view('admin.services', $data);
        }
        abort(404);
    }
}
