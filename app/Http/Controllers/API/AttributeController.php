<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Attribute; 
use App\Models\AttributeGroup; 
use Auth;
class AttributeController extends BaseController
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
            return  Attribute::latest()->where('merchant_id',Auth::user()->userable_id)->with('Group')->paginate(10);
        } 
        
    } 
    public function attributelookups()
    {
        if (\Gate::allows('isAdminOrMerchant')) { 
            return AttributeGroup::latest()->where('merchant_id',Auth::user()->userable_id)->get();
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
            'attribute_group_id' => 'required|integer',
            'sort_order' => 'required|string',
            'name_ar' => 'required|string'
            
          ]);   
        
       return Attribute::create([
            'name_ar'=>$request['name_ar'],  
            'name_en'=>$request['name_en'],
            'merchant_id'=>Auth::user()->userable_id??0,
            'attribute_group_id'=>$request['attribute_group_id'],
            'sort_order'=>$request['sort_order']
        ]);
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getAttribute($id)
    { 
        if (\Gate::allows('isAdminOrMerchant')) { 
           
            return Attribute::latest()->with('Group')->where('id',$id)->first();
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
        $Attribute=Attribute::where('id',$id)->first();
        
        $this->validate($request, [
            'attribute_group_id' => 'required|integer',
            'sort_order' => 'required|string',
            'name_ar' => 'required|string'
            
          ]);   
 
        $created= $Attribute->update([
            'name_ar'=>$request['name_ar'],  
            'name_en'=>$request['name_en'],
            'attribute_group_id'=>$request['attribute_group_id'],
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
        $Attribute=Attribute::where('id',$id)->first();  
        $Attribute->delete();
        return ['message'=>'Item deleted'];
    }
}