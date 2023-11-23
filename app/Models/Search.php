<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Search extends Model
{
    use HasFactory;

    function unpackFilters()
    {
        return "Unpacking Fucking Filters";
    }

    /**
     * Blank Query
     * 
     * @return dictionary -returns the latest entry
     */
    function blank($limit, $offset, $filters)
    {
        try
        {
            $data = DB::select(DB::raw(
                "SELECT
                    aw.id
                    ,aw.title
                    ,aw.date
                    ,aw.department
                    ,aw.description
                    ,aw.type_of_work
                    ,authors_temp.collapsed_authors
                    FROM academic_works AS aw
                    LEFT JOIN(
                        SELECT 
                        authors.academic_works_id, 
                        GROUP_CONCAT(
                            JSON_OBJECT(
                                'name',CONCAT(authors.prefix,' ',authors.given_name,' ',authors.middle_name,' ',authors.last_name,' ',authors.suffix)
                                ,'department',authors.department
                            ) 
                            SEPARATOR '\0'
                        )AS collapsed_authors 
                        FROM authors 
                        GROUP BY authors.academic_works_id
                    )AS authors_temp 
                    ON authors_temp.academic_works_id = aw.id
                    ORDER BY aw.id 
                    DESC"
            ));
    
            for($i = 0; $i < count($data); $i++)
            {   
                //Convert Collapsed Authors String
                //Split at separator null
                //Store Collapsed Authors String into the same dict:key
                $data[$i]->collapsed_authors = explode("\0",$data[$i]->collapsed_authors);

                //Blur ID
                $data[$i]->id = blur($data[$i]->id);

                //Convert The Collapsed Authors String into JSON or a Dictionary
                for($j = 0; $j < count($data[$i]->collapsed_authors); $j++)
                {
                    $data[$i]->collapsed_authors[$j] = json_decode($data[$i]->collapsed_authors[$j]);
                }
            }

            return response(["unpackFilters"=>$this->unpackFilters(), "data"=>$data], 200)->header('Content-Type', 'application/json');
        }
        catch(Throwable $e){return response(["message"=>$e->getMessage()], 200)->header('Content-Type', 'application/json');}
        
    }

    function singleWord()
    {
        return "fuck";
    }

    function multiWord()
    {

    }
}
