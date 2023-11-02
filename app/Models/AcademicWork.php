<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class AcademicWork extends Model
{
    use HasFactory;

    public function authors()
    {
        return $this->hasMany("App\Author");
    }

    //NON-FETCHABLE
    public function grabMoreDetails($id)
    {
        try
        {
            $academic_works = DB::select(
                DB::raw(
                    "SELECT
                    aw.title
                    ,aw.date
                    ,aw.department
                    ,aw.description
                    ,aw.abstract
                    ,aw.type_of_work
                    ,authors_temp.collapsed_authors
                    FROM academic_works AS aw
                    LEFT JOIN(
                        SELECT 
                        authors.academic_works_id, 
                        GROUP_CONCAT(
                            JSON_OBJECT(
                                'name',CONCAT(authors.prefix,' ',authors.given_name,' ',authors.middle_name,' ',authors.last_name,' ',authors.suffix)
                                ,'dob',authors.date_of_birth
                                ,'department',authors.department
                            ) 
                            SEPARATOR '\0'
                        )AS collapsed_authors 
                        FROM authors 
                        GROUP BY authors.academic_works_id
                    )AS authors_temp 
                    ON authors_temp.academic_works_id = aw.id
                    WHERE aw.id = ". unblur($id)
                )
            )[0];

            //Convert Collapsed Authors String
            //Split at separator null
            //Store Collapsed Authors String into the same dict:key
            $academic_works->collapsed_authors = explode("\0",$academic_works->collapsed_authors);

            //Convert The Collapsed Authors String into JSON or a Dictionary
            for($authors_index = 0; $authors_index < count($academic_works->collapsed_authors); $authors_index++)
            {
                $academic_works->collapsed_authors[$authors_index] = json_decode($academic_works->collapsed_authors[$authors_index]);
            }

            return $academic_works;
        }
        catch(Throwable $e) {return $e;}
    }

    /**
     * Get Partial 2 Information From DB for the cards
     *
     * @param $limit {integer}
     * @param $offset {integer}
     * @return Dictionary
     */
    public function grabCardsPartial($limit = 100, $offset = 0)
    {
        try
        {
            $academic_works = DB::select(
                DB::raw(
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
                    DESC 
                    LIMIT {$limit} 
                    OFFSET {$offset}"
                )
            );
            
            for($academic_works_index = 0; $academic_works_index < count($academic_works); $academic_works_index++)
            {   
                //Convert Collapsed Authors String
                //Split at separator null
                //Store Collapsed Authors String into the same dict:key
                $academic_works[$academic_works_index]->collapsed_authors = explode("\0",$academic_works[$academic_works_index]->collapsed_authors);

                //Blur ID
                $academic_works[$academic_works_index]->id = blur($academic_works[$academic_works_index]->id);

                //Convert The Collapsed Authors String into JSON or a Dictionary
                for($authors_index = 0; $authors_index < count($academic_works[$academic_works_index]->collapsed_authors); $authors_index++)
                {
                    $academic_works[$academic_works_index]->collapsed_authors[$authors_index] = json_decode($academic_works[$academic_works_index]->collapsed_authors[$authors_index]);
                }
            }
            return response(["message"=>"OK", "data"=>$academic_works], 200);
        }
        catch(Throwable $e){return response(["message"=>$e->getMessage()], 200)->header('Content-Type', 'application/json');}
    }
}
