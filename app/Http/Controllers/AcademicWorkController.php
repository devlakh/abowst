<?php

namespace App\Http\Controllers;

use App\Models\AcademicWork;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Runner\Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class AcademicWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("work.index");
        // return view("work.index",["papers" => AcademicWork::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("work.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $academic_work = new AcademicWork();
        $author = new Author();

        $academic_work_input = json_decode($request->all()["academic_work"], true);
        $author_input = json_decode($request->all()["authors"], true);

        try
        {
            DB::beginTransaction();
            $id = $academic_work->insertGetId($academic_work_input);
            for($i = 0; $i < count($author_input); $i++) $author_input[$i]["academic_works_id"] = $id;
            $author->insert($author_input);
            DB::commit();
        }
        catch(Throwable $e)
        {
            DB::rollback();
            return response(["Message"=>$e->getMessage()], 200)->header('Content-Type', 'application/json');
        }

        return response(["Message"=>"Data Inserted To Database"], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function grabCardsPartial(Request $request)
    {
        try
        {
            $limit = $request->input("limit");
            $offset = $request->input("offset");

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
                        ,authors.prefix
                        ,authors.given_name
                        ,authors.middle_name
                        ,authors.last_name
                        ,authors.suffix
                        ,authors.department AS author_department
                    FROM" 
                    .
                    "(SELECT * FROM academic_works LIMIT {$limit} OFFSET {$offset}) AS aw LEFT JOIN authors ON aw.id = authors.academic_works_id"
                )
            );


            return response(["Data"=>$academic_works], 200)->header('Content-Type', 'application/json');
        }
        catch(Throwable $e)
        {
            return response(["Message"=>$e->getMessage()], 200)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
