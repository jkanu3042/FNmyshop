<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Cart
{



    private $storageKey;
    private $storage;
    private $request;
    /** @var Collection */
    private $instance;

    public function __construct(Repository $cache, Request $request)
    {
        $this->storage = $cache;
        $this->request = $request;
        $this->storageKey = 'cart.'. $request->user('customers')->id;
        $this->initialize();
    }

    public function items()
    {
        return $this->instance;
    }


    public function add(Buyable $buyable, int $quantity = 1)
    {
        $found = $this->findItem($buyable);

        if($found) {
//            $this->update($buyable,$found->quantity() + $quantity);
//            return;
        }


        $buyable->setQuantity($quantity);
        $this->instance->push($buyable);
        $this->saveToStorage();

    }

    public function findItem(Buyable $buyable)
    {
        return $this->instance->filter(function (Buyable $oldItem) use ($buyable) {
            return $oldItem->isSameAs($buyable);
        })->first();
    }

    private function saveToStorage()
    {
        $expireAt = Carbon::now()->addDay(1);

        $this->storage->put(
            $this->storageKey, $this->instance, $expireAt
        );
    }


    private function initialize()
    {
        $this->instance = $this->storage->get($this->storageKey) ?:
            collect([]);
    }

}
