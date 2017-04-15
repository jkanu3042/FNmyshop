<?php

namespace Tests\Feature;

use App\Cart;
use App\Customer;
use App\Member;
use App\Product;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class CartTest extends TestCase
{
    use DatabaseMigrations;
    /** @var Customer */
    protected $customer;

    /** @var Cart */
    protected $cart;

    /** @var Request */
    protected $request;

    /** @var CacheManager */
    protected $storage;

    public function setUp()
    {
        parent::setUp();
        $this->createCartStorage();
        $this->createCustomer();
        $this->createRequest();
        $this->createCart();

    }

    private function createCartStorage()
    {
        $this->storage = app(Repository::class);
    }

    private function createCustomer()
    {
        $this->customer = factory(Customer::class)->create();
    }

    private function createRequest()
    {
        $this->request = request()->setUserResolver(function(){
            return $this->customer;
        });
    }

    private function createCart()
    {
        $this->cart = new Cart($this->storage,$this->request);
    }

    /** Cart Tests */

    public function test_cart_can_be_instantiable()
    {
        $this->assertInstanceOf
        (Cart::class, $this->cart);

        $this->assertTrue($this->cart->items()->isEmpty());
    }

    public function test_customer_can_add_a_cart_item()
    {
        $member = factory(Member::class)->create();
        $product = factory(Product::class)->create([
            'member_id'=>$member->id,
            'price'=>100,
        ]);


        $this->cart->add($product,1);
        $this->assertCount(1,$this->cart->items());

    }

    private function prepareCategory()
    {
        collect([
            Category::COMPUTER,
            Category::MOBILE,
        ])->each(function ($category) {
            (new Category)->forceFill([
                'name' => $category,
            ])->save();
        });
    }

}