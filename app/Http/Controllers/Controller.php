<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends baseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function landing() 
    {
        return view('dashboard');
    }
}
