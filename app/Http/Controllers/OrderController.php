<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\OrderLine;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

//    public function showAsync(Order $order)
//    {
//        $view = view('orders/show', [
//            'order' => $order
//        ])->render();
//
//        return response()->json(['html' => $view]);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Orders by Role
        switch (auth()->user()->role_id) {
            case Role::admin():
                $orders = Order::all();
                return view('orders/index', [
                    'orders' => $orders,
                ]);
                break;
            case Role::photographer():
                $orders = Order::where('photographer_id', auth()->user()->photographer()->id)->get();
                break;
            case Role::customer():
                $orders = Order::where('customer_id', auth()->user()->customer()->id)->get();
                break;
        }

        //Shortcut of User only has 1 Order
        if ($orders->count() == 1) {
            return redirect('/orders/' . $orders->first()->id);
        } else {
            return view('orders/index', [
                'orders' => $orders,
            ]);
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
        DB::beginTransaction();

        try {
            //Validation
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

            //Delete file after use
            Storage::delete($fileName);

            //Prepare array
            $orderLines = array();

            //Persist Products
            foreach ($products as $product) {

                //If not exists persist product
                $existingProduct = Product::where('barcode', $product['barcode'])->first();
                if ($existingProduct == null) {
                    $p = Product::create([
                        'barcode' => $product['barcode'],
                        'title' => $product['title'],
                        'description' => $product['description'],
                    ]);
                } else {
                    $p = $existingProduct;
                }

                $product['id'] = $p->id;
                $orderLines[] = $p;
            }

            //Persist Order
            $order = Order::create($validated);

            //Persist OrderLines
            foreach ($orderLines as $orderLine) {
                OrderLine::create([
                    'order_id' => $order->id,
                    'product_id' => $orderLine['id'],
                ]);
            }

            DB::commit();

            return redirect('/orders/' . $order->id);
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
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
        //TODO Refactor quick solution
        if ($request['photographer_id']) {
            $order->photographer_id = $request['photographer_id'];
        } else {
            $order->confirmed = true;
            //TODO redirect('customers/edit');
        }

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
