<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\User;
use Auth;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return user::latest()->paginate(10);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
          ]); 

       return User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password'])            
        ]);
         
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
    public function profile()
    {
        return Auth('api')->user();
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
      
       $user=User::findOrFail($id);
       $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => 'sometimes|string'
      ]); 
        $user->update([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password'])            
        ]);
       return ['message'=>'Updated successfully'];
    }
    public function updateProfile(Request $request)
    {
      
       $user=Auth('api')->user();
       //return $request['photo'];
       $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => 'sometimes|required|string'
      ]); 
      $name=$user->photo;
      if($request['photo'] != $user->photo)
      {
          $name=time().'.'.explode('/',explode(':',substr($request['photo'],0,strpos($request['photo'],';')))[1])[1];
          $img = \Image::make($request['photo'])->save(public_path('img/profile/').$name); 
          $userPhoto=public_path('img/profile/').$user->photo;
          if(file_exists($userPhoto))
          {
              @unlink($userPhoto);
          }
      }
        $user->update([
            'name'=>$request['name'],
            'photo'=> $name,
            'email'=>$request['email'],
            'password'=>Hash::make($request['password'])            
        ]);
       return ['message'=>'Updated successfully'];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $user->delete();
        return ['message'=>'User deleted'];
    }
}
