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
use App\ZipCode;
use App\Customer;
use App\Photographer;
use App\User;

class OrderLineStatusTest extends TestCase
{
    protected $order;
    protected $orderline;
    protected $status;
    protected $photo;
    protected $product;
    protected $customer;
    protected $customerUser;
    protected $photographer;
    protected $photographerUser;
    protected $items;


    public function testIsPending()
    {
        // Makes object
        $this->setAttributes();
        $this->status = $this->orderline->isPending();

        // Store every object in array
        $this->items = array($this->photo, $this->orderline, $this->product, $this->order, $this->photographer, $this->customer, $this->customerUser, $this->photographerUser);

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

        $this->items = array($this->photo, $this->orderline, $this->product, $this->order, $this->photographer, $this->customer, $this->customerUser, $this->photographerUser);

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
        $this->status = $this->orderline->id;

        $this->assertEquals($this->status, $this->orderline->id);

        $this->items = array($this->photo, $this->orderline, $this->product, $this->order, $this->photographer, $this->customer, $this->customerUser, $this->photographerUser);

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

        $this->items = array($this->photo, $this->orderline, $this->product, $this->order, $this->photographer, $this->customer, $this->customerUser, $this->photographerUser);

        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    public function setAttributes()
    {

//         REFACTOR WHEN CUSTOMERS & ADMIN/PHOTOGRAPHER IS MADE
        $this->customerUser     = User::Create([
            "email" => "Customer@test.dk",
            "password" => "1234",
            "role_id" => 2,

        ]);
        $this->photographerUser = User::Create([
            "email" => "Photographer@Photographer.dk",
            "password" => "1234",
            "role_id" => 3
        ]);
        $this->photographer     = Photographer::Create([
            "employee_no" => "1222222",
            "user_id" => $this->photographerUser->id
        ]);

        $this->customer = Customer::Create([
            "name_name" => "Test",
            "user_id" => $this->customerUser->id,
//            'zip_code' => "1234",
        ]);

        $this->product   = Product::Create([
            "barcode" => "12344",
            "title" => "Testing",
            "description" => "dadadada"
        ]);
        $this->order     = Order::Create([
            "customer_id" => $this->customer->id,
            "photographer_id" => $this->photographer->id
        ]);
        $this->orderline = OrderLine::Create([
            "order_id" => $this->order->id,
            "product_id" => $this->product->id,
            "status_id" => 1
        ]);
        $this->photo     = Photo::Create([
            "photographer_id" => $this->photographer->id,
            "product_id" => $this->orderline->product_id,
            "path" => " "
        ]);

//        $this->photoline = PhotoLine::Create([
//            "order_line_id" => $this->orderline->id,
//            "photo_id" => $this->photo->id,
//        ]);
    }
}
