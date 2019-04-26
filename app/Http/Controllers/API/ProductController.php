<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; 
use App\User;
use App\Models\Product;
use App\Models\Lengthclass;
use App\Models\LengthclassDescription;
use App\Models\TaxRate;
use App\Models\Weightclass;
use App\Models\WeightclassDescription;
use App\Models\Category; 
use App\Models\ProductCategory; 
use App\Models\ProductImage; 
use App\Models\ProductOption; 
use App\Models\ProductAttribute; 
use App\Models\ProductStore;  
use App\Models\Attribute;  
use Auth;
class ProductController extends BaseController
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
            return  Product::latest()->paginate(10);
        } 
        
    } 
    public function productlookups()
    { 
        if (\Gate::allows('isAdmin')) { 
            $data['lengthclass']= LengthclassDescription::with('Lengthclass')->get(); 
            $data['taxrates']= TaxRate::latest()->get(); 
            $data['weightclass']= WeightclassDescription::with('Weightclass')->get(); 
            $data['categories']= Category::latest()->get(); 
            $data['attributes']= Attribute::latest()->get(); 
            return $data;
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
        //dd($request['attributerows']);
        $this->validate($request, [
            'name_ar' => 'required',
            'price' => 'required|string',
            'code' => 'required|string'
          ]);  
     
        DB::beginTransaction();
        try {    
        $photo="";
        if($request['photo'] != "")
        {
            $photo=time().'.'.explode('/',explode(':',substr($request['photo'],0,strpos($request['photo'],';')))[1])[1];
            $img = \Image::make($request['photo'])->save(public_path('img/product/').$photo); 
        } 
       $product= Product::create([
            'name_ar'=>$request['name_ar'], 
            'name_en'=>$request['name_en'],
            'photo'=>$photo,
            'description'=>$request['description'],
            'code'=>$request['code'],
            'model'=>$request['model'],
            'price'=>$request['price'],
            'tax_id'=>$request['tax_id'],
            'quantity'=>$request['quantity'],
            'minimum'=>$request['minimum'],
            'stock_status_id'=>$request['stock_status_id'],
            'r_shipping'=>$request['r_shipping'],
            'length'=>$request['length'],
            'width'=>$request['width'],
            'heigth'=>$request['heigth'],
            'weight'=>$request['weight'],
            'weight_class_id'=>$request['weight_class_id'],
            'length_class_id'=>$request['length_class_id'],
            'sort_order'=>$request['sort_order'],
            'subtract'=>$request['subtract'],
            'status'=>'1',
            'tag'=>$request['tag'],
            'meta_description'=>$request['meta_description'],
            'meta_keyword'=>$request['meta_keyword']
        ]);
        
        $categories=$request['categories'];
        if($categories!=null){
        foreach($categories as $cateegory){
            //dd();
        ProductCategory::create(
            [
                'product_id'=>$product->id, 
                'category_id'=>$cateegory['id']
            ]
        );
        }
    }
        $attributerows=$request['attributerows'];
        
        if($attributerows!=null){
        foreach($attributerows as $attribute){
            //dd($attribute['attribute_id']);
        ProductAttribute::create(
            [
                'product_id'=>$product->id, 
                'attribute_id'=>$attribute['attribute_id'],
                'text'=>$attribute['text'],
                'language_id'=>1
            ]
        );
        }
        }

        $images=$request['images'];
        
        if($images!=null){
        foreach($images as $image){
            $photo="";
            if($image['image'] != "")
            {
                $photo=time().'.'.explode('/',explode(':',substr($image['image'],0,strpos($image['image'],';')))[1])[1];
                $img = \Image::make($image['image'])->save(public_path('img/product/').$photo); 
            } 
            ProductImage::create(
            [
                'product_id'=>$product->id, 
                'image'=>$photo,
                'sort_order'=>$image['sort_order']
            ]
        );
        }
        }
       
        DB::commit(); 
        return $this->sendResponse($product->id, "Saved!");
        
    } catch (\Exception $e) {
        DB::rollback();  
        return $this->sendError('Server Error.', $e->getMessage());
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProduct($id)
    { 
        if (\Gate::allows('isAdmin')) { 
           
            $data['product']= Product::latest()->where('id',$id)->first();
            $cat=ProductCategory::where('product_id',$id)->pluck('category_id');
            $attributes=ProductAttribute::where('product_id',$id)->get();
            $images=ProductImage::where('product_id',$id)->get();
            $data['categories']=Category::whereIn('id',$cat)->get();
            $data['attributes']=$attributes;//ttribute::whereIn('id',$attributes)->get();
            $data['images']=$images;
            return $data;
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
        $Product=Product::where('id',$id)->first();
        
        $this->validate($request, [
            'name_ar' => 'required',
            'price' => 'required|string',
            'code' => 'required|string'
          ]);  

        $pphoto=$Product->photo; 
        if($request['photo'] != $Product->photo)
        {
            $pphoto=time().'.'.explode('/',explode(':',substr($request['photo'],0,strpos($request['photo'],';')))[1])[1];
            $img = \Image::make($request['photo'])->save(public_path('img/Product/').$pphoto); 
            $photo=public_path('img/Product/').$Product->photo;
            if(file_exists($photo))
            {
                @unlink($photo);
            }
            
        } 
         
        $created= $Product->update([
            'name_ar'=>$request['name_ar'], 
            'name_en'=>$request['name_en'],
            'photo'=>$pphoto,
            'description'=>$request['description'],
            'code'=>$request['code'],
            'model'=>$request['model'],
            'price'=>$request['price'],
            'tax_id'=>$request['tax_id'],
            'quantity'=>$request['quantity'],
            'minimum'=>$request['minimum'],
            'stock_status_id'=>$request['stock_status_id'],
            'r_shipping'=>$request['r_shipping'],
            'length'=>$request['length'],
            'width'=>$request['width'],
            'heigth'=>$request['heigth'],
            'weight'=>$request['weight'],
            'weight_class_id'=>$request['weight_class_id'],
            'length_class_id'=>$request['length_class_id'],
            'sort_order'=>$request['sort_order'],
            'subtract'=>$request['subtract'],
            'status'=>'1',
            'tag'=>$request['tag'],
            'meta_description'=>$request['meta_description'],
            'meta_keyword'=>$request['meta_keyword']
            ]);

            $categories=$request['categories'];
            ProductCategory::where('product_id',$id)->delete();


            foreach($categories as $cateegory){
            ProductCategory::create(
                [
                    'product_id'=>$id, 
                    'category_id'=>$cateegory['id']
                ]
            );
            }

            $attributerows=$request['attributerows'];
            ProductAttribute::where('product_id',$id)->delete();

            foreach($attributerows as $attribute){
                //dd();
            ProductAttribute::create(
                [
                    'product_id'=>$id, 
                    'attribute_id'=>$attribute['attribute_id'],
                    'text'=>$attribute['text'],
                    'language_id'=>1
                ]
            );
            }

            $images=$request['images'];
            $pimages=ProductImage::where('product_id',$id)->get();  
            foreach($pimages as $image){
                $photo=public_path('img/product/').$image->image;
                if(file_exists($photo))
                {
                    @unlink($photo);
                }
                $image->delete();
            }
            if($images!=null){
            foreach($images as $image){
                $photo="";
                //dd($image['image']);
                if($image['image'] != "")
                {
                    $photo=time().'.'.explode('/',explode(':',substr($image['image'],0,strpos($image['image'],';')))[1])[1];
                    
                    $img = \Image::make($image['image'])->save(public_path('img/product/').$photo); 
                } 
                ProductImage::create(
                [
                    'product_id'=>$id,
                    'image'=>$photo,
                    'sort_order'=>$image['sort_order']
                ]
            );
            }
            }
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
        $Product=Product::where('id',$id)->first();  
        ProductCategory::where('product_id',$id)->delete();
        ProductAttribute::where('product_id',$id)->delete();
        $Product->delete();
        return ['message'=>'Item deleted'];
    }
}