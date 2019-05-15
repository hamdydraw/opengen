<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;

use App\Models\Review; 
use Auth;
class ReviewController extends BaseController
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
            return  Review::latest()->paginate(10);
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
            'product_id' => 'required',
            'customer_id' => 'required',
            'text' => 'required',
            'rating' => 'required'
          ]);   
        
       return Review::create([
            'product_id'=>$request['product_id'],
            'customer_id'=>$request['customer_id'],
            'text'=>$request['text'],
            'rating'=>$request['rating'],
            'status'=>1
        ]);
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getReview($id)
    { 
        if (\Gate::allows('isAdmin')) { 
           
            return Review::latest()->where('id',$id)->first();
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
        $Review=Review::where('id',$id)->first();
        $this->validate($request, [
            'product_id' => 'required',
            'customer_id' => 'required',
            'text' => 'required',
            'rating' => 'required'
          ]);   
        
      
        $created= $Review->update([
            'product_id'=>$request['product_id'],
            'customer_id'=>$request['customer_id'],
            'text'=>$request['text'],
            'rating'=>$request['rating'],
            'status'=>1
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
        $Review=Review::where('id',$id)->first();  
        $Review->delete();
        return ['message'=>'Item deleted'];
    }
}