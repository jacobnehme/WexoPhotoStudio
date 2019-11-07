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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
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
//        $validated = $request->validate([
//            'name_first' => ['required', 'min:1', 'max:255'],
//            'name_last' => ['required', 'min:3', 'max:255'],
//            'name_company' => ['required', 'min:3', 'max:255'],
//            'address' => ['required', 'min:3', 'max:255'],
//            'zip_code' => ['required', 'min:3', 'max:255'],
//            'city' => ['required', 'min:3', 'max:255'],
//        ]);

        $existingZipCode = ZipCode::where('zip_code', $request['zip_code'])->first();
        if ($existingZipCode == null) {
            $zipCode = ZipCode::create([
                'zip_code' => $request['zip_code'],
                'city' => $request['city'],
            ]);
        }
        else{
            $zipCode =  $existingZipCode;
        }

        $customer->update([
            'name_first' => $request['name_first'],
            'name_last' => $request['name_last'],
            'name_company' => $request['name_company'],
            'address' => $request['address'],
            'zip_code_id' => $zipCode->id,
        ]);

        return back();
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
