<?php

namespace App\Http\Controllers;

use App\PhotoLine;
use Illuminate\Http\Request;

class PhotoLineController extends Controller
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
        //Validation
        $validated = $request->validate([
            'orderLine_id' => 'required',
            'photo_id' => 'required',
        ]);

        //Persist photoLine
        PhotoLine::create([
            'order_line_id' => (int) $validated['orderLine_id'],
            'photo_id' => (int) $validated['photo_id'],
            'is_approved' => true,
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhotoLine  $photoLine
     * @return \Illuminate\Http\Response
     */
    public function show(PhotoLine $photoLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhotoLine  $photoLine
     * @return \Illuminate\Http\Response
     */
    public function edit(PhotoLine $photoLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhotoLine  $photoLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhotoLine $photoLine)
    {
        $request->has('status') ? $photoLine->approve() : $photoLine->reject();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhotoLine  $photoLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhotoLine $photoLine)
    {
        //
    }
}
