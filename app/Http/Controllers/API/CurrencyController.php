<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Currency; 
use Auth;
class CurrencyController extends Controller
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
            return  Currency::latest()->paginate(10);
        } 
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required', 
            'code' => 'required|string',
          ]);  
        
          return Currency::create([
            'title'=>$request['title'], 
            'code'=>$request['code'], 
            'symbol_left'=>$request['symbol_left'], 
            'symbol_right'=>$request['symbol_right'], 
            'decimal_place'=>$request['decimal_place'],
            'value'=>$request['value'],
            'status'=>$request['status']           
        ]);
 
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCurrency($id)
    {
        return Currency::where('id',$id)->first();
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
        $currency=Currency::where('id',$id)->first();
        
        $this->validate($request, [
            'title' => 'required', 
            'code' => 'required|string',
          ]);   
         $currency->update([
            'title'=>$request['title'], 
            'code'=>$request['code'], 
            'symbol_left'=>$request['symbol_left'], 
            'symbol_right'=>$request['symbol_right'], 
            'decimal_place'=>$request['decimal_place'],
            'value'=>$request['value'],
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
        $currency=Currency::where('id',$id)->first();  
        $currency->delete();
        return ['message'=>'User deleted'];
    }
}
