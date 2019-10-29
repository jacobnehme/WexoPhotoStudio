<?php

namespace App\Http\Controllers;

use App\Photographer;
use Illuminate\Http\Request;

class PhotographerController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photographer  $photographer
     * @return \Illuminate\Http\Response
     */
    public function show(Photographer $photographer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photographer  $photographer
     * @return \Illuminate\Http\Response
     */
    public function edit(Photographer $photographer)
    {
        return view('photographers/edit', [
            'photographer' => $photographer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photographer  $photographer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photographer $photographer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photographer  $photographer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photographer $photographer)
    {
        //
    }
}
