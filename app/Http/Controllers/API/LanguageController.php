<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Language; 
use Auth;
class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        //$this->authorize('isAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin')) { 
            return  Language::latest()->paginate(10);
        } 
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:32', 
            'code' => 'required|string|max:32',
          ]);  
        
          return Language::create([
            'title'=>$request['title'], 
            'code'=>$request['code'], 
            'sort_order'=>$request['sort_order'],  
            'status'=>$request['status']           
        ]);
 
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLanguage($id)
    {
        return Language::where('id',$id)->first();
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
        $Language=Language::where('id',$id)->first();
        
        $this->validate($request, [
            'title' => 'required|string|max:32', 
            'code' => 'required|string|max:32',
          ]);   
         $Language->update([
            'title'=>$request['title'], 
            'code'=>$request['code'], 
            'sort_order'=>$request['sort_order'], 
            'status'=>$request['status']        
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
        $this->authorize('isAdmin');
        $Language=Language::where('id',$id)->first();  
        $Language->delete();
        return ['message'=>'Record deleted successfully!'];
    }
}
