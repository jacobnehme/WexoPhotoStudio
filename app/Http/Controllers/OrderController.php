<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        //Validation (goes here)
        $validated = $request->validate([
        ]);
        $validated['user_id'] = auth()->id();

        //Upload file
        $fileName = $request->file('products')->store('products');

        //Prepare array
        $products = array();

        //Read CSV to array
        $filePath = storage_path('/app/'.$fileName);
        $file = fopen($filePath, "r");
        while ( ($data = fgetcsv($file, 200, ";")) !==FALSE ) {
            $products[] = [
                'title' => $data[0],
                'description' => $data[1],
            ];
        }
        fclose($file);

        //Delete file after use?
        //$fileInfo = explode('/', $fileName);
        Storage::delete($fileName);

        //Another array TODO refactor pls + only need id's
        $products2 = array();

        //Persist Products TODO check if exists (need barcode)
        foreach ($products as $product){

            //If not exists persist product
            $existingProduct = Product::where('title', $product['title'])->first();
            if ($existingProduct == null) {
                $id = Product::create([
                    'title' => $product['title'],
                    'description' => $product['description'],
                ]);
            }
            else
            {
                $id = $existingProduct;
            }

            $product['id'] = $id->id;
            $products2[] = $product;
        }

        //Persist Order
        $order = Order::create($validated);

        //Persist OrderLines
        foreach ($products2 as $product){
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
            ]);
        }

        //Redirect to index TODO maybe created order?
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
