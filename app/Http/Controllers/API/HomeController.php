<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Pilot;
use App\Models\MerchantType;
use App\Models\MobileType;
use App\Models\Country;
use App\Models\Zone; 
use App\Models\Product;
use App\Models\Order;
use App\Models\Settings;
use Auth;
class HomeController extends BaseController
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
            return  Pilot::latest()->paginate(10);
        } 
        
    } 
    public function getProductAlert()
    { 
        if (\Gate::allows('isAdmin') || \Gate::allows('isMerchant')) { 
           
            return Product::latest()->whereColumn('minimum','>','quantity')->where('merchant_id',Auth::user()->userable_id)->get();
        } 
    }

    public function settings()
    { 
        if (\Gate::allows('isAdmin')) { 
           
            return Settings::first();
        } 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatesettings(Request $request,$id)
    {
       $settings= Settings::where('id',$id)->first();
        $settings->update([
            'title'=>$request['title'], 
            'email'=>$request['email'], 
            'mobile'=>$request['mobile'],
            'delivery'=>$request['delivery'],
            'cda'=>$request['cda'],
            'ct'=>$request['ct']
        ]);
 
        return ['message'=>'Updated successfully'];
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPilot($id)
    { 
        if (\Gate::allows('isAdmin')) { 
           
            return Pilot::latest()->where('id',$id)->first();
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
        $pilot=Pilot::where('id',$id)->first();
        
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required|string'
          ]);  

        $pphoto=$pilot->photo; 
        if($request['photo'] != $pilot->photo)
        {
            $pphoto=time().'.'.explode('/',explode(':',substr($request['photo'],0,strpos($request['photo'],';')))[1])[1];
            $img = \Image::make($request['photo'])->save(public_path('img/pilot/').$pphoto); 
            $photo=public_path('img/pilot/').$pilot->photo;
            if(file_exists($photo))
            {
                @unlink($photo);
            }
            
        } 
        
     
        $created= $pilot->update([
            'name'=>$request['name'], 
            'photo'=>$pphoto,
            'merchant_id'=>$request['merchant_id'],
            'mobile'=>$request['mobile']  
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
        $pilot=Pilot::where('id',$id)->first();  
        $pilot->delete();
        return ['message'=>'Item deleted'];
    }
}