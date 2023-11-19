<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    function results(Request $request)
    {
        return view("search.results");
    }

    function query(Request $request)
    {
        return response(["message"=>"Hello Results Searching for".$request->get('query')], 200)->header('Content-Type', 'application/json');
    }
}
