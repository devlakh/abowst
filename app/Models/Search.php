<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;

    /**
     * Blank Query
     * 
     * @return dictionary -returns the latest entry
     */
    function blank()
    {
        return "From Search Model";
    }

    function singleWord()
    {

    }

    function multiWord()
    {

    }
}
