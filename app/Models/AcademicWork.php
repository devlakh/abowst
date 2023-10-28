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


    /**
     * Get Partial Information From DB for the cards
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
                        aw.id AS academic_work_id
                        ,aw.title
                        ,aw.date
                        ,aw.department AS academic_work_department
                        ,aw.description
                        ,aw.type_of_work
                        ,authors.id AS author_id
                        ,CONCAT(authors.prefix,' ',authors.given_name,' ',authors.middle_name,' ',authors.last_name,' ',authors.suffix) AS author_name
                        ,authors.department AS author_department
                    FROM" 
                    .
                    "(SELECT * FROM academic_works ORDER BY academic_works.id DESC LIMIT {$limit} OFFSET {$offset}) AS aw LEFT JOIN authors ON aw.id = authors.academic_works_id"
                )
            );

            return response(["Data"=>$academic_works], 200)->header('Content-Type', 'application/json');
        }
        catch(Throwable $e)
        {
            return response(["Message"=>$e->getMessage()], 200)->header('Content-Type', 'application/json');
        }
    }
}
