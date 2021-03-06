<?php

namespace App\Http\Controllers\Member;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreProductRequest;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:members');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        /** @var Member $member */
        $member = $request->user();

        /** @var Product $product */
        $product = $member->products()->create([
            'category_id' => $request->getCategoryId(),
            'title' => $request->getTitle(),
            'sub_title' => $request->getSubTitle(),
            'price' => $request->getPrice(),
            'options' => $request->getOptions(),
            'description' => $request->getDescription(),
        ]);

        $request->getImages()->each(function (Image $image) use ($product) {
             $image->product()->associate($product)->save();
         });

        return redirect(route('products.index'));

    }

}
