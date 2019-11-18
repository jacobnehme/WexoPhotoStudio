<?php

namespace Tests\Feature;

use App\Customer;
use App\Order;
use App\OrderLine;
use App\Photo;
use App\Photographer;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
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
    public function testCustomerEditView()
    {
//        TODO Show customer show.view

        // Makes object
        $this->setAttributes();

        // Store every object in array
        $this->items = array($this->photo, $this->orderline, $this->product, $this->order, $this->photographer, $this->customer, $this->customerUser, $this->photographerUser);

        // Check if customer can view edit page
        $response = $this->ActingAs($this->customerUser)->get(route('customers.edit',['id' => $this->customer->id]));
        $response->assertSuccessful();
        $response->assertViewIs('customers.edit');

        // Loops over every object and delete it from DB
        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    public function testMyOrdersView ()
    {
        // Makes object
        $this->setAttributes();

        // Store every object in array
        $this->items = array($this->photo, $this->orderline, $this->product, $this->order, $this->photographer, $this->customer, $this->customerUser, $this->photographerUser);

        // If user is logged in check if orders is shown
        $response = $this->ActingAs($this->customerUser)->get(route('orders.show',['id' => $this->order->id]));
        $response->assertSuccessful();
        $response->assertViewIs('orders.show');

        // Loops over every object and delete it from DB
        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    public function testUploadCsvViewIfUserIsLoggedIn()
    {
        // Makes object
        $this->setAttributes();

        // Store every object in array
        $this->items = array($this->photo, $this->orderline, $this->product, $this->order, $this->photographer, $this->customer, $this->customerUser, $this->photographerUser);

        $response = $this->ActingAs($this->customerUser)->get('orders/create');

        $response->assertSuccessful();
        $response->assertViewIs('orders.create');

        // Loops over every object and delete it from DB
        foreach ($this->items as $item) {
            $item->delete();
        }
    }

    public function setAttributes()
    {
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
    }
}
