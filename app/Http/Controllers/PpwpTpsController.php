<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpwpTps;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
class PpwpTpsController extends Controller
{
    //
    public function index(){
        
        $data = PpwpTps::whereNotNull('pengguna_total_j')->whereRaw('COALESCE(suara_paslon_1, 0) + COALESCE(suara_paslon_2, 0) + COALESCE(suara_paslon_3, 0) > COALESCE(pengguna_total_j, 0)')->paginate(10);        
        return Inertia::render('Welcome',[
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'tables'=>$data,
        ]);
        
    }
}
