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
use App\Models\OrderHistory; 
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
            'customer' => 'required',
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
            'order_status_id' => 'required',
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
            'customer_id'=>$request['customer']['id'],
            'customer_name'=>$request['customer']['name'],
            'customer_email'=>$request['customer']['email'],
            'customer_telephone'=>$request['customer']['telephone'],
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
            'currency_code'=>$request['currency_id']['code'],
            'currency_value'=>$request['currency_id']['value'],
            'ip'=>request()->server('SERVER_ADDR'),
            'user_agent'=>$request->header('User-Agent')

            
        ]);
        
        OrderHistory::create([ 
            'order_id'=>$order->id, 
            'order_status_id'=>$request['order_status_id'],
            'comment'=>$request['comment'],
            'order_status_name'=>OrderStatus::where('id',$request['order_status_id'])->first()->name_ar,
            'notify'=>0
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
                        'price'=>$row['product']['price'],
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
            $data['history']=OrderHistory::where('order_id',$id)->get(); 
            return $data;
        
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function addHistory(Request $request, $id)
    {
        $notify=0;
        if($request['notify']=="true")
        $notify=1;
        OrderHistory::create([ 
            'order_id'=>$id, 
            'order_status_id'=>$request['order_status_id'],
            'comment'=>$request['comment'],
            'order_status_name'=>OrderStatus::where('id',$request['order_status_id'])->first()->name_ar,
            'notify'=>$notify
        ]);
    }
    public function update(Request $request, $id)
    { 
        if (\Gate::allows('isAdminOrMerchant')) { 
        //dd($request['photo']);
        $order=Order::where('id',$id)->first();
        
        $this->validate($request, [
            'customer' => 'required',
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
            'order_status_id' => 'required',
            'payment_method' => 'required|string',
          ]);  

      
          $total=0;
          $rows=$request['productsrows'];
          if($rows!=null){
          foreach($rows as $row){
              $total+=$row['total'];
          }}
        $created= $order->update([
            'customer_id'=>$request['customer']['id'],
            'customer_name'=>$request['customer']['name'],
            'customer_email'=>$request['customer']['email'],
            'customer_telephone'=>$request['customer']['telephone'],
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
            'currency_code'=>$request['currency_id']['code'],
            'currency_value'=>$request['currency_id']['value'],
            ]);

            
            OrderProduct::where('order_id',$id)->delete();
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
                            'price'=>$row['product']['price'],
                            'total'=>$row['total'],
                            'tax'=>0,
                            'reward'=>0
                        ]
                    );
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
        $order=Order::where('id',$id)->first();  
        OrderProduct::where('order_id',$id)->delete();
        $order->delete();
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