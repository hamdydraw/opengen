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
use App\Models\OrderStatus;  
use App\Models\currency;  
use App\Models\Customer;  
use App\Models\Order; 
use App\Models\OrderProduct; 
use Auth;
class OrderController extends BaseController
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isEU')) 
          return  Order::latest()->with('OrderStatus')->paginate(10); 
        if (\Gate::allows('isMerchant')) {
          return  Order::latest()->with('OrderStatus')->where('merchant_id',Auth::user()->userable_id)->paginate(10); 
        }
    } 
    public function searchorders(Request $request)
    {
        $orders=  Order::latest()->with('OrderStatus')->where('merchant_id',Auth::user()->userable_id);
        if( $request['id']!=null &&  $request['id']!='')
        $orders= $orders->where('id',$request['id']);
        if( $request['customer']!=null &&  $request['customer']!='')
        $orders= $orders->where('customer_name','like','%'.$request['customer'].'%');
        if( $request['status']!=null &&  $request['status']!='')
        $orders= $orders->where('order_status_id',$request['status']);

        return $orders->paginate(10); 
    }
    public function orderlookups()
    { 
        if (\Gate::allows('isAdminOrMerchant')) {  
            $data['orderstatuses']= OrderStatus::get(); 
            $data['currencies']= Currency::get(); 
            $data['customers']= Customer::get(); 
            $data['products']= Product::where('merchant_id',Auth::user()->userable_id)->get(); 
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
        if (\Gate::allows('isAdminOrMerchant')) { 
        //dd($request['attributerows']);
        $this->validate($request, [
            'selected' => 'required',
            'currency_id' => 'required',
            'payment_name' => 'required',
            'payment_address_1' => 'required|string',
            'payment_city' => 'required|string',
            'payment_city' => 'required|string',
            'payment_city' => 'required|string',
            'payment_country' => 'required|string',
            'payment_zone' => 'required|string',
            'shipping_name' => 'required',
            'shipping_address_1' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_country' => 'required|string',
            'shipping_zone' => 'required|string',
            'order_status_id' => 'required|string',
            'payment_method' => 'required|string',
          ]);  

        $total=0;
        $rows=$request['productsrows'];
        if($rows!=null){
        foreach($rows as $row){
            $total+=$row['total'];
        }}
        //dd( $total);
        DB::beginTransaction();
        try {    
       
       $order= Order::create([
            'invoice_no'=>1, 
            'merchant_id'=>Auth::user()->userable_id??0,
            'customer_id'=>$request['selected']['id'],
            'customer_name'=>$request['selected']['name'],
            'pilot_id'=>0,
            'payment_name'=>$request['payment_name'],
            'payment_company'=>$request['payment_company'],
            'payment_address_1'=>$request['payment_address_1'],
            'payment_address_2'=>$request['payment_address_2'],
            'payment_city'=>$request['payment_city'],
            'payment_postcode'=>$request['payment_postcode'],
            'payment_country'=>$request['payment_country'],
            'payment_country_id'=>$request['payment_country_id'],
            'payment_zone'=>$request['payment_zone'],
            'payment_method'=>$request['payment_method'],
            'shipping_name'=>$request['shipping_name'],
            'shipping_company'=>$request['shipping_company'],
            'shipping_address_1'=>$request['shipping_address_1'],
            'shipping_address_2'=>$request['shipping_address_2'],
            'shipping_city'=>$request['shipping_city'],
            'shipping_postcode'=>$request['shipping_postcode'],
            'shipping_country'=>$request['shipping_country'],
            'shipping_country_id'=>$request['shipping_country_id'],
            'shipping_zone'=>$request['shipping_zone'],
            'shipping_method'=>$request['shipping_method'],
            'comment'=>$request['comment'],
            'total'=>$total,
            'order_status_id'=>$request['order_status_id'],
            'currency_id'=>$request['currency_id']['id'],
            
        ]);
        
        
        if($rows!=null)
        {
               foreach($rows as $row){ 
                OrderProduct::create(
                    [
                        'order_id'=>$order->id, 
                        'product_id'=>$row['product']['id'],
                        'name'=>$row['product']['name_ar'],
                        'model'=>$row['product']['model'],
                        'quantity'=>$row['quantity'],
                        'price'=>$row['unit_price'],
                        'total'=>$row['total'],
                        'tax'=>0,
                        'reward'=>0
                    ]
                );
                }
         } 

        DB::commit(); 
        return $this->sendResponse($order->id, "Saved!");
        
    } catch (\Exception $e) {
        DB::rollback();  
        return $this->sendError('Server Error.', $e->getMessage());
    }
}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrder ($id)
    { 
             
            $data['order']= Order::latest()->where('id',$id)->first(); 
            $products=OrderProduct::where('order_id',$id)->get(); 
            $data['product']=$products;
           
            return $data;
        
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
        if (\Gate::allows('isAdminOrMerchant')) { 
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

            $discounts=$request['discounts'];
            
            ProductDiscount::where('product_id',$id)->delete();
            if($discounts!=null){
            foreach($discounts as $dsicount){
                //dd($attribute['attribute_id']);
                ProductDiscount::create(
                [
                    'product_id'=>$id, 
                    'quantity'=>$dsicount['quantity'],
                    'priority'=>$dsicount['priority'],
                    'price'=>$dsicount['price'],
                    'date_start'=>$dsicount['date_start'],
                    'date_end'=>$dsicount['date_end']
                ]
            );
            }
            }

            $images=$request['images'];
            $pimages=ProductImage::where('product_id',$id)->get();  
          
            if($images!=null){
            foreach($images as $image){

                /*foreach($pimages as $oimage){
                    $photo=public_path('img/product/').$oimage->image;
                    if(file_exists($photo) && $image['image'] != $oimage->image)
                    {
                        @unlink($photo);
                    }
                    $oimage->delete();
                }*/
                $photo="";
                //dd($image['image']);
                if($image['image'] != "")
                {
                    try{
                            $photo=time().'.'.explode('/',explode(':',substr($image['image'],0,strpos($image['image'],';')))[1])[1]; 
                            $img = \Image::make($image['image'])->save(public_path('img/product/').$photo);  
                            ProductImage::create(
                                [
                                    'product_id'=>$id,
                                    'image'=>$photo,
                                    'sort_order'=>$image['sort_order']
                                ]
                            );
                    }
                    catch(\Exception $e){}
                } 
           
            }
            }
       return ['message'=>'Updated successfully'];
        }
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
        $Product=Product::where('id',$id)->first();  
        ProductCategory::where('product_id',$id)->delete();
        ProductAttribute::where('product_id',$id)->delete();
        ProductDiscount::where('product_id',$id)->delete();
        $Product->delete();
        return ['message'=>'Item deleted'];
    }

    public function findProduct()
    {
        
        $query=\Request::get('q');
        if (\Gate::allows('isAdmin') || \Gate::allows('isMerchant')) { 
            return Product::where('code',$query)
            ->where('merchant_id',Auth::user()->userable_id)
            ->first();
        }
    }
    public function updatequantity(Request $request, $id)
    { 
        
        $Product=Product::where('id',$id)->first();
        $created= $Product->update([
            'quantity'=>$request['quantity']
            ]);

    }
    
}