<?php

namespace App\Http\Controllers;

use App\Customer;
use App\ZipCode;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * CustomerController constructor.
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
        if ($customer = Customer::all()->where('user_id', '==', auth()->id())->first()){
            return redirect('/customers/'.$customer->id.'/edit');
        }
        else{
            return redirect('/customers/create');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required'],
            'name_first' => ['required', 'min:1', 'max:255'],
            'name_last' => ['required', 'min:3', 'max:255'],
            'name_company' => ['required', 'min:3', 'max:255'],
            'address' => ['required', 'min:3', 'max:255'],
            'zip_code' => ['required', 'min:3', 'max:255'],
            'city' => ['required', 'min:3', 'max:255'],
        ]);


        $existingZipCode = ZipCode::where('zip_code', $validated['zip_code'])->first();
        if ($existingZipCode == null) {
            $zipCode = ZipCode::create([
                'zip_code' => $validated['zip_code'],
                'city' => $validated['city'],
            ]);
        }
        else{
              $zipCode =  $existingZipCode;
        }

        $validated['zip_code'] = $zipCode->id;
        unset($validated['city']);

        $customer = Customer::create($validated);

        return redirect('/customers/'.$customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('customers/show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers/edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}