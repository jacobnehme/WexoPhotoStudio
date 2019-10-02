<?php

namespace App\Http\Controllers;

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
        //TODO mime validation gives me errors
        //Validation
        $validated = $request->validate([
            'orderLine_id' => 'required',
            'product_id' => 'required',
            'photo' => 'required',
        ]);

        //Upload photo
        $fileName = $request->file('photo')->store('photos', 'public');

        // Persist Photo
        $Photo = Photo::create([
            'user_id' => auth()->id(),
            'product_id' => (int) $validated['product_id'],
            'path' => $fileName,
        ]);

        //Persist photoLine
        PhotoLine::create([
            'order_line_id' => (int) $validated['orderLine_id'],
            'photo_id' => $Photo->id,
        ]);

        return back();
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
