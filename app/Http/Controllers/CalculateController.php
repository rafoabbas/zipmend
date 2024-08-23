<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'salam' => 'asda'
        ]);
    }
}
