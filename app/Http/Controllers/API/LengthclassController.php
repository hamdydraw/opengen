<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Lengthclass;
use App\Models\LengthclassDescription; 
use Auth;
class LengthclassController extends Controller
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
            return  LengthclassDescription::with('Lengthclass')->paginate(10);
        } 
    }
    public function Lengthclasslookups()
    {
        if (\Gate::allows('isAdmin')) { 
            return LengthclassDescription::with('Lengthclass')->get();
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
            'value' => 'integer'
            ]);  
          
       $created= Lengthclass::create([
            'value'=>$request['value']   
        ]); 
        
       return LengthclassDescription::create([
            'length_class_id'=>$created->id,
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
    public function getLengthclass($id)
    {
        return LengthclassDescription::with('Lengthclass')->where('length_class_id',$id)->first();
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
        $Lengthclass=Lengthclass::where('id',$id)->first();
        
        $this->validate($request, [
            'title' => 'required|max:32', 
            'code' => 'required|string|max:4',
            'value' => 'integer',
            ]);  

        
        $created= $Lengthclass->update([
                'value'=>$request['value']    
            ]);

      LengthclassDescription::where('length_class_id',$id)->where('language_id',1)->delete();
      LengthclassDescription::create([
                  'length_class_id'=>$id,
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
        $Lengthclass=Lengthclass::where('id',$id)->first(); 
        LengthclassDescription::where('length_class_id',$id)->where('language_id',1)->delete();
        $Lengthclass->delete();
        return ['message'=>'User deleted'];
    }
}
