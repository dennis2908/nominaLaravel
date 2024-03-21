<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;
use Validator;

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Hobby::latest()->get();
		
		return response()->json(['result'=>$data]);
    }

    public function dataList()
    {
        $data = Hobby::latest()->get();
		
		return response()->json(['result'=>$data]);
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
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|min:3',
            'aktif' => 'required'
      ]);
      
      
      if ($validator->passes()) {
          
          $mcustomer = new Hobby;
          $mcustomer->name  = $request->name;
          $mcustomer->aktif = $request->aktif;
          $mcustomer->save();

          return response()->json(['success'=>'Added new record.']);

      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|min:3',
            'aktif' => 'required'
      ]);
      
      
      if ($validator->passes()) {
          
          $hobby =  Hobby::find($id);
          $hobby->name  = $request->name;
          $hobby->aktif = $request->aktif;

          $hobby->save();

          return response()->json(['success'=>'Added new record.']);

      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Hobby::destroy($id))
             return response()->json(['success'=>'Delete existing record.']);
    }
}
