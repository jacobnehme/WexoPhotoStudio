<?php

namespace App\Http\Controllers;

use App\Events\PhotoUploaded;
use App\OrderLine;
use App\Photo;
use App\PhotoLine;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
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
        $orderLine = OrderLine::where('id', $request['orderLine_id'])->get()->first();

        //Upload photo
        $fileName = $request->file('photo')->store('', 'images');

        // Persist Photo
        $Photo = Photo::create([
            'photographer_id' => $orderLine->order->photographer()->id,
            'product_id' => $orderLine->product->id,
            'path' => $fileName,
        ]);

        //Persist photoLine
        PhotoLine::create([
            'order_line_id' => (int) $request['orderLine_id'],
            'photo_id' => $Photo->id,
        ]);

        PhotoUploaded::dispatch();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
