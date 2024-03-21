<?php

namespace App\Http\Controllers;

use App\Models\Muser;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Crypt;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class MuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Muser::select(['musers.id','musers.firstname','musers.lastname','musers.age','musers.created_at','musers.m_role','hobbies.name as hobby_name','musers.email','role_name'])->join('mroles','mroles.id','=','musers.m_role')->join('hobbies','hobbies.id','=','musers.hobby')->latest()->get();
		
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function doLogin(Request $request)
    {
       $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	//return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }
 	
 		//Token created, return with success response and jwt token
		$data = Muser::select(['musers.firstname','musers.lastname','password','role_name','role_assign'])->join('mroles','mroles.id','=','musers.m_role')
        ->where('musers.email','=',$request->email)
        ->first();
        return response()->json([
            'success' => true,
            'token' => $token,
			'result'=>$data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'age' => 'required|integer',
            'password' => 'required|min:3',
            'hobby' => 'required',
            'email'=>'required|min:3|email',
            'm_role'=>'required'
      ]);
      
      
      if ($validator->passes()) {
          
          $muser = new Muser;
          $muser->firstname  = $request->firstname;
          $muser->email  = $request->email;
          $muser->m_role  = $request->m_role;
          $muser->lastname = $request->lastname;
          $muser->age  = $request->age;
          $muser->password  = bcrypt($request->password);
          $muser->hobby  = $request->hobby;
          $muser->save();

          return response()->json(['success'=>'Added new record.']);

      }

      return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Muser  $muser
     * @return \Illuminate\Http\Response
     */
    public function show(Muser $muser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Muser  $muser
     * @return \Illuminate\Http\Response
     */
    public function edit(Muser $muser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Muser  $muser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|min:3',
            'username' => 'required|min:3',
            'address' => 'required|min:3',
            'password' => 'required|min:3',
            'phone' => 'required|min:3',
            'email'=>'required|min:3|email',
            'm_role'=>'required'
      ]);
      
      
      if ($validator->passes()) {
          
          $muser =  Muser::find($id);
          $muser->name  = $request->name;
          $muser->email  = $request->email;
          $muser->m_role  = $request->m_role;
          $muser->username = $request->username;
          $muser->address  = $request->address;
          $muser->password  = bcrypt($request->password);
          $muser->phone  = $request->phone;
          $muser->save();

          return response()->json(['success'=>'Update existing record.']);

      }

      return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Muser  $muser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Muser::destroy($id))
             return response()->json(['success'=>'Delete existing record.']);
    }
}
