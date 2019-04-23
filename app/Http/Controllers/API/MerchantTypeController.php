<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\MerchantType; 
use Auth;
class MerchantTypeController extends BaseController
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
            return  MerchantType::latest()->paginate(10);
        } 
        
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
            'name_ar' => 'required|string',
            'name_en' => 'required|string'
          ]);   
        
       return MerchantType::create([
            'name_ar'=>$request['name_ar'],  
            'name_en'=>$request['name_en']
        ]);
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMerchantType($id)
    { 
        if (\Gate::allows('isAdmin')) { 
           
            return MerchantType::latest()->where('id',$id)->first();
        } 
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
        //dd($request['photo']);
        $MerchantType=MerchantType::where('id',$id)->first();
        
        $this->validate($request, [
            'name_ar' => 'required',
            'name_en' => 'required|string'
          ]);  
 
        $created= $MerchantType->update([
            'name_ar'=>$request['name_ar'], 
            'name_en'=>$request['name_en']  
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
        $MerchantType=MerchantType::where('id',$id)->first();  
        $MerchantType->delete();
        return ['message'=>'Item deleted'];
    }
}