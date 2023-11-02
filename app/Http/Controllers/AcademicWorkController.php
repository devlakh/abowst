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

        $academic_work_input = json_decode($request->input("academic_work"), true);
        $author_input = json_decode($request->input("authors"), true);

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
            return response(["message"=>$e->getMessage()], 200)->header('Content-Type', 'application/json');
        }

        return response(["message"=>"Data Inserted To Database"], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function grabCardsPartial(Request $request)
    {
        $academic_work = new AcademicWork();

        $limit = $request->input("limit");
        $offset = $request->input("offset");

        return $academic_work->grabCardsPartial($limit, $offset);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $academic_work = new AcademicWork();

        $data = $academic_work->grabMoreDetails($id);

        //Check if type of work starts with vowels then prefix with an or a
        if(preg_match('/^[aeiou]/i', $data->type_of_work)) $data->type_of_work = "An " . ucfirst($data->type_of_work);
        else $data->type_of_work = "A " . ucfirst($data->type_of_work);

        $data->department = ucfirst($data->department);

        $exploded_date = explode("-",$data->date);
        $data->date = date('F', mktime(0, 0, 0, $exploded_date[1], 10)) . " " .$exploded_date[2] . ", " . $exploded_date[0];

        for($i = 0; $i < count($data->collapsed_authors); $i++)
        {
            if(strlen(trim($data->collapsed_authors[$i]->name)) == 0 or $data->collapsed_authors[$i]->name == null)
            {
                $data->collapsed_authors[$i]->name = "Anon";
            }

            if(strlen(trim($data->collapsed_authors[$i]->dob)) == 0 or $data->collapsed_authors[$i]->dob == null)
            {
                $data->collapsed_authors[$i]->dob = "At Some Moment In Time";
            }

            if(strlen(trim($data->collapsed_authors[$i]->department)) == 0 or $data->collapsed_authors[$i]->department == null)
            {
                $data->collapsed_authors[$i]->department = "Some Department Or None";
            }

        }

        return view("work.show", ["data"=>$data]);
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
