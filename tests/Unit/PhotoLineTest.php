<?php

namespace Tests\Unit;

use App\OrderLine;
use App\Order;
use App\Photo;
use App\Product;


use App\PhotoLine;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhotoLineTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected $order;
    protected $orderline;
    protected $photoline;
    protected $photo;
    protected $product;
    protected $user;
    protected $items;


    // APPROVE STATUS TEST
    public function test_photoLine_approve()
    {
        // Makes objects
        $this->setAttributes();

        // Store every object in array
        $this->items = array($this->photoline, $this->orderline, $this->order, $this->photo, $this->product, $this->user);

        // Sets status to true
        $this->photoline->approve();

        // Check if status is true
        $this->assertTrue($this->photoline->status);

        // Loops over every object and delete it from DB
        foreach ($this->items as $item) {
            $item->delete();
        }

    }

    // REJECT STATUS TEST
    public function test_photoLine_reject()
    {
        // Makes objects
        $this->setAttributes();

        // Store every object in array
        $this->items = array($this->photoline, $this->orderline, $this->order, $this->photo, $this->product, $this->user);

        // Sets status to true
        $this->photoline->reject();

        // Check if status is false
        $this->assertFalse($this->photoline->status);

        // Loops over every object and delete it from DB
        foreach ($this->items as $item) {
            $item->delete();
        }

    }

    public function setAttributes()
    {
        // REFACTOR WHEN CUSTOMERS & ADMIN/PHOTOGRAPHER IS MADE
        $this->user = User::Create([
            "name" => "Test",
            "email" => "test@test.dk",
            "password" => "1234",
        ]);
        $this->product   = Product::Create([
            "barcode" => "12344",
            "title" => "Testing",
            "description" => "dadadada"
        ]);
        $this->order     = Order::Create([
            "user_id" => $this->user->id
        ]);
        $this->orderline = OrderLine::Create([
            "order_id" => $this->order->id,
            "product_id" => $this->product->id
        ]);
        $this->photo     = Photo::Create([
            "user_id" => $this->user->id,
            "product_id" => $this->orderline->product_id,
            "path" => " "
        ]);
        $this->photoline = PhotoLine::Create([
            "order_line_id" => $this->orderline->id,
            "photo_id" => $this->photo->id,
        ]);
    }
}

