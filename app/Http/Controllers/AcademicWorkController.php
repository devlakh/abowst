<?php

namespace App\Http\Controllers;

use App\Models\AcademicWork;
use Illuminate\Http\Request;

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
        if (isset($_POST))
        {
            $academic_work = new AcademicWork();
            // $request->input("authors")
            //$request->all()

            $academic_work->title = $request->input("title");
            $academic_work->date = $request->input("date");
            $academic_work->department = $request->input("department");
            $academic_work->type_of_work = $request->input("type_of_work");
            $academic_work->description = $request->input("description");
            $academic_work->abstract = $request->input("abstract");

            $academic_work->save();

            return response(["Message"=>"Data Inserted To Database"], 200)->header('Content-Type', 'application/json');
        }

        return response(["Message"=>"No Post Request"], 200)->header('Content-Type', 'application/json');
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
