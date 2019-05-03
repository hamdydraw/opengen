<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\AttributeGroup; 
use App\Models\AttributeGroupGroup; 
use Auth;
class AttributeGroupController extends BaseController
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
            return  AttributeGroup::latest()->where('merchant_id',Auth::user()->userable_id)->paginate(10);
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
            'sort_order' => 'required|integer',
            'name_ar' => 'required|string'
            
          ]);   
        
       return AttributeGroup::create([
            'name_ar'=>$request['name_ar'],  
            'name_en'=>$request['name_en'],
            'merchant_id'=>Auth::user()->userable_id??0,
            'sort_order'=>$request['sort_order']
        ]);
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAttributeGroup($id)
    { 
        if (\Gate::allows('isAdminOrMerchant')) { 
           
            return AttributeGroup::latest()->where('merchant_id',Auth::user()->userable_id)->where('id',$id)->first();
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
        $AttributeGroup=AttributeGroup::where('id',$id)->first();
        
        $this->validate($request, [ 
            'sort_order' => 'required|integer',
            'name_ar' => 'required|string' 
          ]);   
 
        $created= $AttributeGroup->update([
            'name_ar'=>$request['name_ar'],  
            'name_en'=>$request['name_en'],
            'sort_order'=>$request['sort_order']
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
        $this->authorize('isAdminOrMerchant');
        $AttributeGroup=AttributeGroup::where('id',$id)->first();  
        $AttributeGroup->delete();
        return ['message'=>'Item deleted'];
    }
}