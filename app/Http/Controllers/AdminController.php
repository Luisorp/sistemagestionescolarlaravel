<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use App\Models\Periodo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $total_gestiones = Gestion::count();
        $total_periodos = Periodo::count();

        return view('admin.index', compact('total_gestiones', 'total_periodos'));
    }
}
