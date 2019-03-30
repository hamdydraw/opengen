<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Weightclass;
use App\Models\WeightclassDescription; 
use Auth;
class WeightclassController extends Controller
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
            return  WeightclassDescription::with('Weightclass')->paginate(10);
        } 
    }
    public function Weightclasslookups()
    {
        if (\Gate::allows('isAdmin')) { 
            return WeightclassDescription::with('Weightclass')->get();
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
            'title' => 'required|max:32', 
            'code' => 'required|string|max:4',
            'value' => 'numeric',
            ]);  
          
       $created= Weightclass::create([
            'value'=>$request['value']   
        ]); 

       return WeightclassDescription::create([
            'weight_class_id'=>$created->id,
            'language_id'=>1,
            'title'=>$request['title'],
            'code'=>$request['code']      
        ]);
        
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getWeightclass($id)
    {
        return WeightclassDescription::with('Weightclass')->where('weight_class_id',$id)->first();
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
        $Weightclass=Weightclass::where('id',$id)->first();
        
        $this->validate($request, [
            'title' => 'required|max:32', 
            'code' => 'required|string|max:4',
            'value' => 'numeric',
            ]);  

        
        $created= $Weightclass->update([
                'value'=>$request['value']    
            ]);

      WeightclassDescription::where('weight_class_id',$id)->where('language_id',1)->delete();
      WeightclassDescription::create([
                  'weight_class_id'=>$id,
                    'language_id'=>1,
                    'title'=>$request['title'],
                    'code'=>$request['code']         
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
        $Weightclass=Weightclass::where('id',$id)->first(); 
        WeightclassDescription::where('weight_class_id',$id)->where('language_id',1)->delete();
        $Weightclass->delete();
        return ['message'=>'User deleted'];
    }
}
