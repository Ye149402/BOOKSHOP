<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('role:owner')->only('index');
        $this->middleware('role:customer')->only('store');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $orders = Order::orderBy('id', 'desc')->get();
        return view('backend.order.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth()->user()->id;
        $order->orderno = uniqid();
        $order->phone = $request->phone;
        $order->shipping_address = $request->address;
        $order->payment_type = $request->payment;
        $total = 0;

        $itemArray = json_decode($request->itemstring);
        foreach($itemArray as $item) {
            $total += $item->price * $item->qty;
        }
        $order->total = $total;
        $order->save();

        foreach($itemArray as $item) {
            $order->books()->attach($item->id, ['quantity' => $item->qty]);
        }

        // json response
        return response()->json([
            'order' => $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
      $book->load('author','category');
        
         return view('backend.order.detail',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('backend.order.edit', compact('book', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}