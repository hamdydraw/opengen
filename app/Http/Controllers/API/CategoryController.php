<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\CategoryPath;
use Auth;
class CategoryController extends Controller
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
        if (\Gate::allows('isMerchant')) { 
            return  Category::latest()->where('merchant_id',Auth::user()->userable_id)->paginate(10);
        } 
    }
    public function categorylookups()
    {
        if (\Gate::allows('isMerchant')) { 
            return Category::latest()->where('merchant_id',Auth::user()->userable_id)->get();
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
            'status' => 'required',
           // 'language_id' => 'required|integer',
            'name_ar' => 'required|string',
          ]);  
          $name="";
        if($request['image'] != "")
        {
            $name=time().'.'.explode('/',explode(':',substr($request['image'],0,strpos($request['image'],';')))[1])[1];
            $img = \Image::make($request['image'])->save(public_path('img/uploads/').$name); 
            
        } 
       return Category::create([
            'parent_id'=>$request['parent_id'],
            'top'=>0,//$request['top'],
            'image'=>$name,
            'name_ar'=>$request['name_ar'],
            'name_en'=>$request['name_en'],
            'merchant_id'=>Auth::user()->userable_id??0,
            'description'=>$request['description'],
            'sort_order'=>$request['sort_order'],
            'status'=>$request['status']        
        ]);

       /*return CategoryDescription::create([
            'category_id'=>$created->id,
            'language_id'=>1,
            'name'=>$request['name'],
            'description'=>$request['description'],
            'meta_title'=>$request['meta_title'],
            'meta_description'=>$request['meta_description'],
            'meta_keyword'=>$request['meta_keyword']        
        ]);*/
        
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCategory($id)
    {
        return Category::latest()->where('id',$id)->first();
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
        $category=Category::where('id',$id)->first();
        
        $this->validate($request, [
            'status' => 'required',
        // 'language_id' => 'required|integer',
            'name_ar' => 'required|string',
        ]);  
        $name=$category->image; 
        if($request['image'] != $category->image)
        {
            $name=time().'.'.explode('/',explode(':',substr($request['image'],0,strpos($request['image'],';')))[1])[1];
            $img = \Image::make($request['image'])->save(public_path('img/uploads/').$name); 
            $userPhoto=public_path('img/uploads/').$category->image;
            if(file_exists($userPhoto))
            {
                @unlink($userPhoto);
            }
            
        } 
        $created= $category->update([
                'parent_id'=>$request['parent_id'],
                'top'=>0,//$request['top'],
                'image'=>$name,
                'name_ar'=>$request['name_ar'],
                'name_en'=>$request['name_en'],
                'description'=>$request['description'],
                'sort_order'=>$request['sort_order'],
                'status'=>$request['status']        
            ]);
      /*CategoryDescription::where('category_id',$id)->where('language_id',1)->delete();
      CategoryDescription::create([
                'category_id'=>$id,
                'language_id'=>1,
                'name'=>$request['name'],
                'description'=>$request['description'],
                'meta_title'=>$request['meta_title'],
                'meta_description'=>$request['meta_description'],
                'meta_keyword'=>$request['meta_keyword']        
            ]);*/
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
        
        
        $this->authorize('isMerchant');
        $category=Category::where('id',$id)->first(); 
       // CategoryDescription::where('category_id',$id)->where('language_id',1)->delete();
        $category->delete();
        return ['message'=>'User deleted'];
    }
}
