<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\OrderLine;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        return view('orders/index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO transaction, file reader, clean up and more...
        $validated = $request->validate([
        ]);
        $validated['user_id'] = auth()->id();

        //File Stuff
        $products = array();
        $filePath = $request->file('products')->store('products');
        $filename = storage_path('/app/'.$filePath);
        $all_data = array();
        $file = fopen($filename, "r");
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ) {

            $title = $data[0];
//            $description = $data[1];
            $all_data = $title;

            array_push($products, $all_data);

//            Product::create([
//                'title' => $data[0],
//                'description' => $data[1],
//            ]);
        }

        dd($all_data);

        $order = Order::create($validated);

        $products = Product::all();
        foreach ($products as $product){
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
            ]);
        }
        return redirect('/orders');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('orders/show', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
