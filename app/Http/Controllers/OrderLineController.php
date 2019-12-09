<?php

namespace App\Http\Controllers;

use App\Events\OrderLineStatusUpdated;
use App\Events\PhotoUploaded;
use App\OrderLine;
use App\PhotoLine;
use App\Status;
use Illuminate\Http\Request;

class OrderLineController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\OrderLine $orderLine
     * @return \Illuminate\Http\Response
     */
    public function show(OrderLine $orderLine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\OrderLine $orderLine
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderLine $orderLine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\OrderLine $orderLine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderLine $orderLine)
    {
      /*  if (!$orderLine->isStatus('active') or !$orderLine->isStatus('pending')){
            return 'Hacker!';
        }*/

        //Persist PhotoLines if pre-approving
        if($request['photos']){

            foreach ($orderLine->photoLines() as $photoLine){
                $photoLine->delete();
            }

            foreach ($request['photos'] as $photo){
                PhotoLine::create([
                    'order_line_id' => $orderLine->id,
                    'photo_id' => $photo,
                ]);
            }
        }

        //Update Status
        switch ($request['status_id']) {
            case Status::pending():
                $orderLine->pending();
                break;
            case Status::active():
                $orderLine->active();
                break;
            case Status::rejected():
                $orderLine->reject();
                break;
            case Status::approved():
                $orderLine->approve();
                break;
            case Status::preApproved():
                $orderLine->preApprove();
                $fileNames = [];
                foreach ($orderLine->photoLines() as $photoLine){
                    $fileNames[] = $photoLine->photo()->path;
                }
                PhotoUploaded::dispatch($orderLine, $fileNames);
                break;
        }

        OrderLineStatusUpdated::dispatch($orderLine);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\OrderLine $orderLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderLine $orderLine)
    {
        //
    }
}
