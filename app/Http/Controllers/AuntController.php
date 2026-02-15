<?php

namespace App\Http\Controllers;

class AuntController extends Controller
{
    public function index()
    {
        return response()->json(['ok' => true]);
    }
}
