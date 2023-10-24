<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function splash()
    {
        return view("landing.splash");
    }

    public function about()
    {
        return view("landing.about");
    }

    public function contact()
    {
        return view("landing.contact");
    }
}
