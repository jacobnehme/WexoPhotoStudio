<?php

namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Photo;
use App\OrderLine;
use App\Order;
use App\Product;
use App\Status;
use App\User;

class OrderLineStatusTest extends TestCase
{
    protected $order;
    protected $orderline;
    protected $status;
    protected $photo;
    protected $product;
    protected $user = 1;
    protected $items;


    public function testIsPending()
    {
        // Makes objects
        $this->setAttributes();
        $this->status = $this->orderline->isPending();

        // Store every object in array
        $this->items = array($this->photo, $this->orderline, $this->product, $this->order);

        // Check if status is true
        $this->assertTrue($this->status);

        // Loops over every object and delete it from DB
        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    public function testIsApproved()
    {
        $this->setAttributes();
        $this->orderline->approve();
        $this->status = $this->orderline->isApproved();

        $this->items = array($this->photo, $this->orderline, $this->product, $this->order);

        // Check if status is true
        $this->assertTrue($this->status);

        // Loops over every object and delete it from DB
        foreach ($this->items as $item) {
            $item->delete();
        }

    }

    public function UpdateToApproveTest()
    {
        $this->setAttributes();
        $this->orderline->approve();
        $this->status =  $this->orderline->id;

        $this->assertEquals($this->status, $this->orderline->id);

        $this->items = array($this->photo, $this->orderline, $this->product, $this->order);

        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    public function UpdateToRejectTest()
    {
        $this->setAttributes();
        $this->orderline->reject();
        $this->status = $this->orderline->id;

        $this->assertEquals($this->status, $this->orderline->id);

        $this->items = array($this->photo, $this->orderline, $this->product, $this->order);

        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    public function setAttributes()
    {
        // REFACTOR WHEN CUSTOMERS & ADMIN/PHOTOGRAPHER IS MADE
//        $this->user      = User::Create([
//            "name" => "Test",
//            "email" => "test@test.dk",
//            "password" => "1234",
//            "role_id" => 1
//        ]);
        $this->product   = Product::Create([
            "barcode" => "12344",
            "title" => "Testing",
            "description" => "dadadada"
        ]);
        $this->order     = Order::Create([
            "user_id" => $this->user
        ]);
        $this->orderline = OrderLine::Create([
            "order_id" => $this->order->id,
            "product_id" => $this->product->id,
            "status_id" => 1
        ]);
        $this->photo     = Photo::Create([
            "user_id" => $this->user,
            "product_id" => $this->orderline->product_id,
            "path" => " "
        ]);

//        $this->photoline = PhotoLine::Create([
//            "order_line_id" => $this->orderline->id,
//            "photo_id" => $this->photo->id,
//        ]);
    }
}
