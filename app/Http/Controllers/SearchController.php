<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function results(Request $request)
    {
        return view("search.results");
    }

    function query(Request $request)
    {
        $search = new Search();
        $query = $request->get('query');
        $filters = json_decode($request->get('filters'));
        $result = array();

        //Check if query is Whitespaces or Empty
        if (ctype_space($query) || $query == "") {
            $result = $search->blank();
        }

        return response(
            [
                "message"=>"Hello Results Searching for ". $query . "with filters " . json_encode($filters), 
                "data" => $result
            ]
            , 200)->header('Content-Type', 'application/json');
    }
}
