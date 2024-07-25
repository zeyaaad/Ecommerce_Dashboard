<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrdersController extends Controller
{
     public function index()
    {
        $orders = DB::table("orders")->select("*")->get();
        $customer_names=[];
        foreach($orders as $order){
            $cust=DB::table("customers")->where("id",$order->customer_id)->first();
            $customer_names[$order->customer_id]=$cust->name;
        }

        return view("AllOrders", compact("orders","customer_names"));
    }
    public function detalis($id) {
        $order = DB::table("orders")->where("id",$id)->first();
        $allproducts=[];
        foreach(json_decode($order->products,true) as $product) {
            $prod=[];
            $prod['quantity']=$product['quantity'];
            $productsData=DB::table("products")->select("*")->where("id",$product["id"])->first();
            $prod["data"]=$productsData;
            $allproducts[]=$prod;
        }
         return view("Orderdetalis", compact("order" , "allproducts"));
    }

}
