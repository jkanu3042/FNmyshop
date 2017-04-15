<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Image;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    const IMAGE_DIR="public/product_images";

    public function index()
    {
        //
}

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
    public function store(StoreImageRequest $request)
    {
        $images = collect([]);

        /** @var UploadedFile $image */
        foreach ($request->getImages() as $image) {
            $filename = $image->store(self::IMAGE_DIR);

            $savedImage = Image::create([
                'filename' => pathinfo($filename, PATHINFO_BASENAME),
                'bytes' => $image->getClientSize(),
                'mime' => $image->getClientMimeType(),
            ]);

            $images->push($savedImage);
        }

        return $images;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
