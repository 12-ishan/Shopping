<?php

namespace App\Http\Requests;

// use Illuminate\Foundation\Http\FormRequest;

// class StoreProductRequest extends FormRequest
// {
//     public function rules()
//     {
//         $rules = [
//             'name' => 'required',
//             'price' => 'required',
//             'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ];

//         if ($this->input('type') == 1) {
            
//             $rules['sku'] = 'required|unique:product_variation,sku';
//         }

//         return $rules;
//     }

//     public function messages()
//     {
//         return [
//             'sku.required' => 'The SKU is required.',
//             'sku.unique' => 'The SKU has already been taken. Please choose a different one.',
//         ];
//     }
// }
