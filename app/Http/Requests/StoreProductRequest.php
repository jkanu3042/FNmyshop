<?php

namespace App\Http\Requests;

use App\Image;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends ShopRequest
{

    public function rules()
    {
        return [
            'category' => 'required|exists:categories,id',
            'title' => 'required|min:6',
            'sub_title' => 'min:6',
            'price' => 'required|integer',
            'options' => 'array',
            'options.*.name' => 'min:2',
            'options.*.value' => 'min:2',
            'description' => 'required|min:6',
        ];
    }

    public function getCategoryId()
    {
        return $this->input('category');
    }

    public function getTitle()
    {
        return $this->input('title');
    }

    public function getSubTitle()
    {
        return $this->input('sub_title');
    }

    public function getPrice()
    {
        return $this->input('price');
    }

    public function getOptions()
    {
        $options = collect([]);

        $options->push([
            $this->input('options.0.name') =>
                $this->input('options.0.value'),
        ]);

        return $options;
    }

    public function getDescription()
    {
        return $this->input('description');
    }

    public function getImages()
    {
        return Image::whereIn('id',
            $this->input('images',[])
        )->get();
    }


}
