<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestion;
use App\Models\Periodo;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $total_gestiones = Gestion::count();
        $total_periodos = Periodo::count();

        return view('home', compact('total_gestiones', 'total_periodos'));
    }
}