<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;

use App\Models\Evaluation; 
use Auth;
class EvaluationController extends BaseController
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
          
         $evaluations=  Evaluation::latest()->with('FromUser')->where('to_user_id',Auth::user()->id)->paginate(10);
        
         return $evaluations;
        
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
            'from_user_id' => 'required',
            'text' => 'required',
            'rating' => 'required'
          ]);   
        
       return Evaluation::create([
            'from_user_id'=>$request['from_user_id'],
            'to_user_id'=>$request['to_user_id'],
            'merchant_id'=>$request['merchant_id'],
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
    public function getEvaluation($id)
    { 
        
        return Evaluation::latest()->where('id',$id)->first();
        
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
        $Evaluation=Evaluation::where('id',$id)->first();
        $this->validate($request, [
            'from_user_id' => 'required',
            'text' => 'required',
            'rating' => 'required'
          ]);   
        
      
        $created= $Evaluation->update([
            'from_user_id'=>$request['from_user_id'],
            'to_user_id'=>$request['to_user_id'],
            'merchant_id'=>$request['merchant_id'],
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
        
        $Evaluation=Evaluation::where('id',$id)->first();  
        $Evaluation->delete();
        return ['message'=>'Item deleted'];
    }
}