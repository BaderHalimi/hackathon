<?php

namespace App\Http\Controllers;

use App\Support\HomeContent;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', ['home' => HomeContent::all()]);
    }
}
