<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\TripsTiming; 
use Auth;
class TripstimingController extends Controller
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
        if (\Gate::allows('isAdminOrMerchant')) { 
            return  TripsTiming::latest()->paginate(10);
        } 
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'timing' => 'required|string'
          ]);  
        
          return TripsTiming::create([
            'timing'=>$request['timing'], 
            'details'=>$request['details'], 
            'merchant_id'=>Auth::user()->userable_id
        ]);
 
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTripsTiming($id)
    {
        return TripsTiming::where('id',$id)->first();
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
        $TripsTiming=TripsTiming::where('id',$id)->first();
        
        $this->validate($request, [
            'timing' => 'required|string'
          ]);   
         $TripsTiming->update([
            'timing'=>$request['timing'], 
            'details'=>$request['details'], 
            'merchant_id'=>Auth::user()->userable_id    
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
        
        $TripsTiming=TripsTiming::where('id',$id)->first();  
        $TripsTiming->delete();
        return ['message'=>'Record deleted successfully!'];
    }
}
