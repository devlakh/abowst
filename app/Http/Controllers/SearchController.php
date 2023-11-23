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
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $query = $request->get('query');
        $filters = json_decode($request->get('filters'));
        $result = array();

        //Check if query is Whitespaces or Empty
        if (ctype_space($query) || $query == "") {
            $result = $search->blank($limit, $offset, $filters);
        }

        return $result;
    }
}
