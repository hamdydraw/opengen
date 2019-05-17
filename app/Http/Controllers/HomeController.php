<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; 
use App\Models\OrderProduct; 
use App\Models\OrderHistory; 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function printOrder($id)
    { 
            $data['id']=$id;
            $data['order']= Order::latest()->where('id',$id)->first(); 
            $products=OrderProduct::where('order_id',$id)->get(); 
            
            $data['products']=$products; 
            $data['history']=OrderHistory::where('order_id',$id)->get(); 
           
            return view('print',$data);
        
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
