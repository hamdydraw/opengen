<?php

namespace App\Http\Controllers\Merchant\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Merchant;
use App\Models\MerchantType;
use App\Models\MobileType;
use Auth;
class MerchantController extends Controller
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
            return  Merchant::latest()->with('MerchantType','MobileType')->paginate(10);
        } 
    }
    public function merchantlookups()
    {
        if (\Gate::allows('isAdmin')) { 
            return Merchant::latest()->with('MerchantType','MobileType')->get();
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
            'name_ar' => 'required',
            'merchant_type_id' => 'required|integer',
            'city_id' => 'required|integer',
            'country_id' => 'required|integer',
            'mobile' => 'required|integer',
            'mobile_type_id' => 'required|integer',
          ]);  
        $owner_photo="";
        if($request['owner_photo'] != "")
        {
            $owner_photo=time().'.'.explode('/',explode(':',substr($request['owner_photo'],0,strpos($request['owner_photo'],';')))[1])[1];
            $img = \Image::make($request['owner_photo'])->save(public_path('img/merchant/').$owner_photo); 
        } 
        $photo="";
        if($request['photo'] != "")
        {
            $photo=time().'.'.explode('/',explode(':',substr($request['photo'],0,strpos($request['photo'],';')))[1])[1];
            $img = \Image::make($request['photo'])->save(public_path('img/merchant/').$photo); 
        } 
       return Merchant::create([
            'name_ar'=>$request['name_ar'],
            'name_en'=>$request['name_en'],
            'owner_photo'=>$owner_photo,
            'merchant_type_id'=>$request['merchant_type_id'],
            'city_id'=>$request['city_id'],
            'country_id'=>$request['country_id'],
            'location'=>$request['location'],
            'mobile'=>$request['mobile'],
            'mobile_type_id'=>$request['mobile_type_id'],
            'haveHW'=>$request['haveHW'],
            'haveSW'=>$request['haveSW']
        ]);
 
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getMerchant($id)
    {
        return Merchant::latest()->with('MerchantType','MobileType')->where('id',$id)->first();
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
        $merchant=Merchant::where('id',$id)->first();
        
        $this->validate($request, [
            'name_ar' => 'required',
            'merchant_type_id' => 'required|integer',
            'city_id' => 'required|integer',
            'country_id' => 'required|integer',
            'mobile' => 'required|integer',
            'mobile_type_id' => 'required|integer',
          ]);  

        $photo=$merchant->photo; 
        if($request['photo'] != $merchant->photo)
        {
            $name=time().'.'.explode('/',explode(':',substr($request['photo'],0,strpos($request['photo'],';')))[1])[1];
            $img = \Image::make($request['photo'])->save(public_path('img/merchant/').$name); 
            $photo=public_path('img/merchant/').$merchant->photo;
            if(file_exists($photo))
            {
                @unlink($photo);
            }
            
        } 
        $owner_photo=$merchant->owner_photo; 
        if($request['owner_photo'] != $merchant->owner_photo)
        {
            $name=time().'.'.explode('/',explode(':',substr($request['owner_photo'],0,strpos($request['owner_photo'],';')))[1])[1];
            $img = \Image::make($request['owner_photo'])->save(public_path('img/merchant/').$name); 
            $photo=public_path('img/merchant/').$merchant->owner_photo;
            if(file_exists($photo))
            {
                @unlink($photo);
            }
            
        } 
        $created= $merchant->update([
            'name_ar'=>$request['name_ar'],
            'name_en'=>$request['name_en'],
            'owner_photo'=>$owner_photo,
            'merchant_type_id'=>$request['merchant_type_id'],
            'city_id'=>$request['city_id'],
            'country_id'=>$request['country_id'],
            'location'=>$request['location'],
            'mobile'=>$request['mobile'],
            'mobile_type_id'=>$request['mobile_type_id'],
            'haveHW'=>$request['haveHW'],
            'haveSW'=>$request['haveSW']     
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
        $merchant=Merchant::where('id',$id)->first();  
        $merchant->delete();
        return ['message'=>'Item deleted'];
    }
}
