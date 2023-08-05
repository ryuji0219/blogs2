<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetXdebugController extends Controller
{
    public function __invoke(Request $request)
    {
        $status = 'xdebug';
        return response()->json([
            'status' => $status
        ]);
    }
}