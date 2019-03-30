<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\TaxRate; 
use Auth;
class TaxRateController extends Controller
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
            return  TaxRate::latest()->paginate(10);
        } 
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:32', 
            'rate' => 'required|numeric',
            'type' => 'required|string|max:1',
          ]);  
        
          return TaxRate::create([
            'name'=>$request['name'], 
            'rate'=>$request['rate'], 
            'type'=>$request['type']       
        ]);
 
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTaxRate($id)
    {
        return TaxRate::where('id',$id)->first();
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
        $TaxRate=TaxRate::where('id',$id)->first();
        
        $this->validate($request, [
            'name' => 'required|max:32', 
            'rate' => 'required|numeric',
            'type' => 'required|string|max:1',
          ]);   
         $TaxRate->update([
            'name'=>$request['name'], 
            'rate'=>$request['rate'], 
            'type'=>$request['type']        
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
        $TaxRate=TaxRate::where('id',$id)->first();  
        $TaxRate->delete();
        return ['message'=>'Record deleted successfully!'];
    }
}
