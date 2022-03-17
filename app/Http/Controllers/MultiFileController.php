<?php

namespace App\Http\Controllers;

use App\Models\MultiFile;
use Illuminate\Http\Request;

class MultiFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('multiFiles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        $validatedData = $request->validate([
//            'files' => 'required',
//            'files.*' => 'mimes:csv,txt,xlx,xls,pdf'
//        ]);


        if($request->TotalFiles > 0)
        {

            for ($x = 0; $x < $request->TotalFiles; $x++)
            {
                if ($request->hasFile('files'.$x))
                {
                    $file      = $request->file('files'.$x);
//                    $path = $file->store('public/files');
                    $name = $file->getClientOriginalName();
                    $path =  $file->move('MultiFile',$name);

                    $insert[$x]['name'] = $name;
                    $insert[$x]['path'] = $path;
                }
            }
            MultiFile::insert($insert);
            return response()->json(['success'=>'Multiple FIle has been uploaded using ajax into db and storage directory']);

        }
        else
        {
            return response()->json(["message" => "Please try again."]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MultiFile  $multiFile
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $files=MultiFile::all();
        return response()->json([
           'files'=>$files,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MultiFile  $multiFile
     * @return \Illuminate\Http\Response
     */
    public function edit(MultiFile $multiFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MultiFile  $multiFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MultiFile $multiFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MultiFile  $multiFile
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)

    {
        $item=MultiFile::find($id);
        $item->delete();
        return response()->json([
            'success'=>"File Deleted",
        ]);
        //
    }
}
