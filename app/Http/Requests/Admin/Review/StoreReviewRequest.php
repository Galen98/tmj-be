<?php

namespace App\Http\Requests\Admin\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'cust_name' => [
                'required',
                'string',
                'max:150',
            ],

            'asal_kota' => [
                'nullable',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'image1' => [
                'nullable',
                'image',
                'max:5120',
            ],

            'image2' => [
                'nullable',
                'image',
                'max:5120',
            ],

            'image3' => [
                'nullable',
                'image',
                'max:5120',
            ],

            'image4' => [
                'nullable',
                'image',
                'max:5120',
            ],

            'image5' => [
                'nullable',
                'image',
                'max:5120',
            ],

            'status' => [
                'required',
                'boolean',
            ],

        ];
    }
}
