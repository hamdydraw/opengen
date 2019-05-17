<html dir="ltr" lang="en"><head>
    <meta charset="UTF-8">
    <title>Order</title>
    <base href="https://demo.opencart.com/admin/">
    <link href="view/javascript/bootstrap/css/bootstrap.css" rel="stylesheet" media="all">
    <script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
    <link href="view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="all">
    </head>
    <body>
    <div class="container">
    <div style="page-break-after: always;">
    <h1>Order #{{$order->id}}</h1>
    <table class="table table-bordered">
    <thead>
    <tr>
    <td colspan="2">Order Details</td>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td style="width: 50%;"> 
    <b>Customer name</b>  {{ $order->customer->name}}<br>
    <b>E-Mail</b>  {{ $order->customer->email}}<br>
    <b>Mobile</b>  {{ $order->customer->telephone}}<br>
    <td style="width: 50%;"><b>Date Added</b> {{$order->created_at}} <br>
    <b>Order ID:</b> {{$order->id}}<br>
    <b>Payment Method</b> Cash On Delivery<br>
    <b>Shipping Method</b> Flat Shipping Rate<br>
    </td>
    </tr>
    </tbody>
    </table>
    <table class="table table-bordered">
    <thead>
    <tr>
    <td style="width: 50%;"><b>Payment Address</b></td>
    <td style="width: 50%;"><b>Shipping Address</b></td>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td><address>
        {{$order->payment_name}}<br>{{$order->payment_address_1}}<br>{{$order->payment_city}}<br>{{$order->payment_address_2}}<br>{{$order->payment_postcode}}<br>{{$order->payment_zone}}<br>{{$order->payment_country}}
    </address></td>
    <td><address>
    {{$order->shipping_name}}<br>{{$order->shipping_address_1}}<br>{{$order->shipping_city}}<br>{{$order->shipping_address_2}}<br>{{$order->shipping_postcode}}<br>{{$order->shipping_zone}}<br>{{$order->shipping_country}}
    </address></td>
    </tr>
    </tbody>
    </table>
    <table class="table table-bordered">
    <thead>
    <tr>
    <td><b>Product</b></td> 
    <td class="text-right"><b>Quantity</b></td>
    <td class="text-right"><b>Unit Price</b></td>
    <td class="text-right"><b>Total</b></td>
    </tr>
    </thead>
    <tbody>
    @foreach ($products as $item) 
    <tr>
    <td>{{ $item->name}}    </td>
    <td class="text-right">{{ $item->quantity}}</td>
    <td class="text-right">{{ $item->price}}</td>
    <td class="text-right">{{ $order->symbol_left}}{{ $item->total}} {{ $order->symbol_right}}</td>
    </tr>
    @endforeach
    <tr>
    <td class="text-right" colspan="3"><b>Sub-Total</b></td>
    <td class="text-right">{{ $order->symbol_left}}{{ $products->sum('total')}}{{ $order->symbol_right}}</td>
    </tr>
     
    <tr>
    <td class="text-right" colspan="3"><b>Total</b></td>
    <td class="text-right">{{ $order->symbol_left}}{{ $products->sum('total')}}{{ $order->symbol_right}}</td>
    </tr>
    </tbody>
    </table>
     
    </div>
    </div>
    
    </body></html>