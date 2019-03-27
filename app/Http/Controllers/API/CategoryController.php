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
        if (\Gate::allows('isAdmin')) { 
            return  CategoryDescription::latest()->with('Category')->paginate(10);
        } 
    }
    public function categorylookups()
    {
        if (\Gate::allows('isAdmin')) { 
            return CategoryDescription::latest()->with('Category')->get();
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
            'name' => 'required|string',
          ]);  
          $name="";
        if($request['image'] != "")
        {
            $name=time().'.'.explode('/',explode(':',substr($request['image'],0,strpos($request['image'],';')))[1])[1];
            $img = \Image::make($request['image'])->save(public_path('img/uploads/').$name); 
            
        } 
       $created= Category::create([
            'parent_id'=>$request['parent_id'],
            'top'=>0,//$request['top'],
            'image'=>$name,
            'sort_order'=>$request['sort_order'],
            'status'=>$request['status']        
        ]);

       return CategoryDescription::create([
            'category_id'=>$created->id,
            'language_id'=>1,
            'name'=>$request['name'],
            'description'=>$request['description'],
            'meta_title'=>$request['meta_title'],
            'meta_description'=>$request['meta_description'],
            'meta_keyword'=>$request['meta_keyword']        
        ]);
        
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCategory($id)
    {
        return CategoryDescription::latest()->with('Category')->where('category_id',$id)->first();
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
            'name' => 'required|string',
        ]);  
        $name="";
        if($request['image'] != "")
        {
            $name=time().'.'.explode('/',explode(':',substr($request['image'],0,strpos($request['image'],';')))[1])[1];
            $img = \Image::make($request['image'])->save(public_path('img/uploads/').$name); 
            
        } 
        $created= $category->update([
                'parent_id'=>$request['parent_id'],
                'top'=>0,//$request['top'],
                'image'=>$name,
                'sort_order'=>$request['sort_order'],
                'status'=>$request['status']        
            ]);
      CategoryDescription::where('category_id',$id)->where('language_id',1)->delete();
      CategoryDescription::create([
                'category_id'=>$id,
                'language_id'=>1,
                'name'=>$request['name'],
                'description'=>$request['description'],
                'meta_title'=>$request['meta_title'],
                'meta_description'=>$request['meta_description'],
                'meta_keyword'=>$request['meta_keyword']        
            ]);
       return ['message'=>'Updated successfully'];
    }
    public function updateProfile(Request $request)
    {
       
       $record=CategoryDescription::latest()->with('Category')->where('category_id',$request[])->first();
       //return $request['photo'];
       $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => 'sometimes|required|string'
      ]); 
      $name=$user->photo;
      if($request['photo'] != $user->photo)
      {
          $name=time().'.'.explode('/',explode(':',substr($request['photo'],0,strpos($request['photo'],';')))[1])[1];
          $img = \Image::make($request['photo'])->save(public_path('img/profile/').$name); 
          $userPhoto=public_path('img/profile/').$user->photo;
          if(file_exists($userPhoto))
          {
              @unlink($userPhoto);
          }
      }
         if (empty($request['password'])) {
            $password = $user->password;
        } else {
            $password=Hash::make($request['password'])  ;
        }
        $user->update([
            'name'=>$request['name'],
            'photo'=> $name,
            'email'=>$request['email'],
            'password'=>$password      
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

        $user=User::findOrFail($id);
        $user->delete();
        return ['message'=>'User deleted'];
    }
}
