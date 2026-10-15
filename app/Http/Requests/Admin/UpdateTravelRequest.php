<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTravelRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $travel = $this->route('travel');

        return [
            'travel_name' => [
                'required',
                'string',
                'max:200',
            ],

            'slug' => [
                'required',
                'string',
                'max:200',
                Rule::unique('travels', 'slug')
                    ->ignore($travel?->id),
            ],

            'short_description' => [
                'required',
                'string',
                'max:500',
            ],

            'options.*.status' => ['sometimes', 'required', 'boolean'],

            'full_description' => [
                'required',
                'string',
            ],

            'cities_id' => [
                'required',
                'exists:cities,id',
            ],

            'point_of_interest_id' => [
                'nullable',
                'exists:point_of_interests,id',
            ],

            'duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'duration_type' => [
                'required',
                'in:jam,hari',
            ],

            'is_pickup' => [
                'required',
                'boolean',
            ],

            'pickup_venue' => [
                'nullable',
                'string',
                'max:255',
            ],

            'is_corporate' => [
                'required',
                'boolean',
            ],

            'is_group' => [
                'required',
                'boolean',
            ],

            'jumlah_peserta' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'is_children' => [
                'required',
                'boolean',
            ],

            'is_discount' => [
                'required',
                'boolean',
            ],

            'price_now' => [
                'required',
                'numeric',
                'min:0',
            ],

            'price_discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Images
            |--------------------------------------------------------------------------
            |
            | Update tidak required karena gambar lama tetap digunakan
            | jika admin tidak upload gambar baru.
            |
            */

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

            /*
            |--------------------------------------------------------------------------
            | Tags
            |--------------------------------------------------------------------------
            */

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'required',
                'integer',
                'distinct',
                'exists:tags,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Includes
            |--------------------------------------------------------------------------
            */

            'includes' => [
                'nullable',
                'array',
            ],

            'includes.*.id' => [
                'nullable',
                'integer',
                'exists:travel_includes,id',
            ],

            'includes.*.include_desc' => [
                'required',
                'string',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | Travel Options
            |--------------------------------------------------------------------------
            */

            'options' => [
                'required',
                'array',
                'min:1',
            ],

            'options.*.id' => [
                'nullable',
                'integer',
                'exists:travel_options,id',
            ],

            'options.*.option_name' => [
                'required',
                'string',
                'max:200',
            ],

            'options.*.description' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | Option Prices
            |--------------------------------------------------------------------------
            */

            'options.*.prices' => [
                'required',
                'array',
                'min:1',
            ],

            'options.*.prices.*.id' => [
                'nullable',
                'integer',
                'exists:travel_option_prices,id',
            ],

            'options.*.prices.*.type' => [
                'required',
                'string',
                'max:20',
            ],

            'options.*.prices.*.label' => [
                'required',
                'string',
                'max:100',
            ],

            'options.*.prices.*.min' => [
                'required',
                'integer',
                'min:0',
            ],

            'options.*.prices.*.max' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'options.*.prices.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Option Times
            |--------------------------------------------------------------------------
            */

            'options.*.times' => [
                'nullable',
                'array',
            ],

            'options.*.times.*.id' => [
                'nullable',
                'integer',
                'exists:travel_option_times,id',
            ],

            'options.*.times.*.time' => [
                'required',
                'date_format:H:i',
            ],

            /*
            |--------------------------------------------------------------------------
            | Option Addons
            |--------------------------------------------------------------------------
            */

            'options.*.addons' => [
                'nullable',
                'array',
            ],

            'options.*.addons.*.id' => [
                'nullable',
                'integer',
                'exists:travel_addons,id',
            ],

            'options.*.addons.*.addon_name' => [
                'required',
                'string',
                'max:150',
            ],

            'options.*.addons.*.description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'options.*.addons.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'options.*.addons.*.min' => [
                'required',
                'integer',
                'min:0',
            ],

            'options.*.addons.*.max' => [
                'required',
                'integer',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }
}
