<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderLocationController extends Controller
{
    public function index()
    {
        $lat = -7.814729;
        $lng = 112.108366;

        return view('lokasi', compact('lat', 'lng'));
    }

}
