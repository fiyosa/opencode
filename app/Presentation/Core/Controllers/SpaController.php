<?php

namespace App\Presentation\Core\Controllers;

use App\Infrastructure\Laravel\Controllers\Controller;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function docs()
    {
        return view('docs');
    }
}
