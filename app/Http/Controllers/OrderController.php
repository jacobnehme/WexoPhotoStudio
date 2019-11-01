<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\OrderLine;
use App\Role;
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

    public function all(){

        $orders = Order::all();

        return view('orders/index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch (auth()->user()->role_id) {
            case Role::customer():
                $orders = Order::where('customer_id', auth()->user()->customer()->id)->get();
                break;
            case Role::photographer():
                $orders = Order::where('photographer_id', auth()->user()->photographer()->id)->get();
                break;
        }

        if ($orders->count() > 1){
            return view('orders/index', [
                'orders' => $orders,
            ]);
        }
        else{
            return redirect('/orders/' . $orders->first()->id);
        }

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO transaction, encapsulation, clean up and more...

        //Validation (goes here)
        $validated = $request->validate([
            'products' => 'required|mimes:txt'
        ]);
        $validated['customer_id'] = auth()->user()->customer()->id;

        //Upload file
        $fileName = $request->file('products')->store('products');

        //Prepare array
        $products = array();

        //Read CSV to array
        $filePath = storage_path('/app/' . $fileName);
        $file = fopen($filePath, "r");
        while (($data = fgetcsv($file, 200, ";")) !== FALSE) {
            $products[] = [
                'barcode' => $data[0],
                'title' => $data[1],
                'description' => $data[2],
            ];
        }
        fclose($file);

        //Delete file after use?
        //$fileInfo = explode('/', $fileName);
        Storage::delete($fileName);

        //Another array TODO refactor pls + only need id's
        $products2 = array();

        //Persist Products
        foreach ($products as $p) {

            //If not exists persist product
            $existingProduct = Product::where('barcode', $p['barcode'])->first();
            if ($existingProduct == null) {
                $product = Product::create([
                    'barcode' => $p['barcode'],
                    'title' => $p['title'],
                    'description' => $p['description'],
                ]);
            } else {
                $product = $existingProduct;
            }

            $product['id'] = $product->id;
            $products2[] = $product;
        }

        //Persist Order
        $order = Order::create($validated);

        //Persist OrderLines
        foreach ($products2 as $product) {
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
            ]);
        }

        return redirect('/orders/' . $order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //$order->photographer_id = auth()->user()->photographer()->id;
        $order->photographer_id = $request['photographer_id'];
        $order->update();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
