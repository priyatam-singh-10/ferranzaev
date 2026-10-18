<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        $type_required = $this->item_type == 'digital' || $this->item_type == 'license' ? '' : 'required';



        $check_link = $this->file_type == 'link' ? 'required' : '';
        if($this->item_type == 'digital'){
            if($this->item){
                $check_file = '';
            }else{
                $check_file = $this->item_type == 'digital' && $this->file_type == 'file' ? 'required' : '';
            }
        }elseif($this->item_type == 'license'){
            if($this->item){
                $check_file = '';
            }else{
                $check_file = $this->item_type == 'license' && $this->file_type == 'file' ? 'required' : '';
            }
        }else{
            $check_file = '';
        }
        $id = $this->item ? ',' . $this->item->id : '';
        $required = $this->item ? '' : 'required';


        return [
            // 'name'            => 'required|max:255|unique:items,name,' . $id,
            // 'slug'            => 'required','unique:items,slug' . $id, 'regex:/^[a-zA-Z0-9-]+$/',
            'name' => 'required|max:255|unique:items,name,' . ($this->item->id ?? 'NULL') . ',id',
            'slug' => 'required|unique:items,slug,' . ($this->item->id ?? 'NULL') . ',id|regex:/^[a-zA-Z0-9-]+$/',

            'category_id'     => 'required',
            'details'         => 'required',
            'link'            => $check_link,
            'file'            => $check_file.'|file|mimes:zip',
            'sort_details'    => 'required',
            'discount_price'  => 'required|numeric|min:0',
            'nonbranded_price'  => 'required|numeric|min:0',
            // 'previous_price'  => 'nullabl|numeric|min:0',
            'stock'           => 'numeric|max:9999999999',
            // 'tax_id'          => 'required',
            'item_color_id'          => 'required',
            'item_model_id'          => 'required',
            'photo' => [
                $required,
                'mimes:jpeg,jpg,png,svg',
                'max:1024',
                'dimensions:max_width=800,max_height=800',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
     
       // 'slug.required'            =>  __('Slug field is required.'),
            // 'slug.unique'              =>  __('This slug has already been taken.'),
    public function messages()
    {

        return [
            'name.required'            =>  __('Name field is required.'),
             'slug.required'            =>  __('Slug field is required.'),
            // 'tax_id.required'          =>  __('Tax field is required.'),
            'item_color_id.required'          =>  __('Color field is required.'),
            'item_model_id.required'          =>  __('Model field is required.'),
            'category_id.required'     =>  __('Category field is required.'),
            'brand_id.required'        =>  __('Brand field is required.'),
          
            'details.required'         =>  __('Description field is required.'),
            'sort_details.required'    =>  __('Sort Description field is required.'),
            'discount_price.required'  =>  __('Current Price field is required.'),
            'nonbranded_price.required'  =>  __('Non Branded Price field is required.'),
            'stock.required'           =>  __('Stock field is required.'),
            'photo.required'           =>  __('Image field is required.'),
            'photo.mimes'              =>  __('Image type must be jpg,jpeg,png,svg.'),
            'photo.max'               => __('Image size must not exceed 1MB.'),
            'photo.dimensions'        => __('Image dimensions must not exceed 800x800 pixels.'),
        ];
    }

}
