<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
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
            'unique:travels,slug',
        ],

        'short_description' => [
            'required',
            'string',
            'max:500',
        ],

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
            'nullable',
            'boolean',
        ],

        'pickup_venue' => [
            'nullable',
            'string',
            'max:255',
        ],

        'is_corporate' => [
            'nullable',
            'boolean',
        ],

        'is_group' => [
            'nullable',
            'boolean',
        ],

        'jumlah_peserta' => [
            'nullable',
            'integer',
            'min:1',
        ],

        'is_children' => [
            'nullable',
            'boolean',
        ],

        'is_discount' => [
            'nullable',
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

        'image1' => [
            'required',
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

        // TAGS

        'tags' => [
            'nullable',
            'array',
        ],

        'tags.*' => [
            'required',
            'distinct',
            'exists:tags,id',
        ],

        // INCLUDES

        'includes' => [
            'nullable',
            'array',
        ],

        'includes.*.include_desc' => [
            'required',
            'string',
            'max:500',
        ],

        // OPTIONS

        'options' => [
            'required',
            'array',
            'min:1',
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

        // OPTION PRICES

        'options.*.prices' => [
            'required',
            'array',
            'min:1',
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

        // OPTION TIMES

        'options.*.times' => [
            'nullable',
            'array',
        ],

        'options.*.times.*.time' => [
            'required',
            'date_format:H:i',
        ],

        // OPTION ADDONS

        'options.*.addons' => [
            'nullable',
            'array',
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

        'status' => [
            'nullable',
            'boolean',
        ],
    ];
}
}
