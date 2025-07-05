<?php

namespace App\Http\Requests\Products;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ProductStoreRequest extends BaseRequest
{
    /**
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
        $rules = [
            'type' => 'required|in:0,1',
            'name' => 'required|unique:products,name',
            'sku' => 'required|unique:products,sku',
            // 'cate_id' => 'required_if:type,0|exists:categories,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'origin_id' => 'nullable|exists:origins,id',
            'intro' => 'nullable',
            'short_des' => 'nullable',
            'body' => 'nullable',
            'base_price' => 'nullable|integer',
            'price' => 'nullable|integer',
            'revenue_price' => 'nullable|numeric|max:' . $this->input('price'),
            'status' =>'required|in:0,1',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:10000',
            'galleries' => 'nullable|array|min:1|max:20',
            'galleries.*.image' => 'nullable|file|mimes:png,jpg,jpeg|max:10000',
            'post_ids' => 'nullable|array|max:5',
            'videos' => 'nullable|array',
            // 'button_type' => 'required|in:0,1',
            // 'person_in_charge' => 'required_if:type,0|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            // 'aff_link' => 'required_if:type,1|url',
            // 'short_link' => 'required_if:type,1|url',
            // 'origin_link' => 'required_if:type,1|url',
        ];

        if($this->input('type') == 0) {
            $rules['cate_id'] = 'required|exists:categories,id';
            // $rules['person_in_charge'] = 'required|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        }

        if($this->input('type') == 1) {
            $rules['aff_link'] = 'required|url';
            $rules['short_link'] = 'required|url';
            $rules['origin_link'] = 'required|url';
        }

        if($this->input('base_price') > 0) {
            $rules['base_price'] = 'nullable|integer|min:' . $this->input('price');
        }

        $url_custom = $this->get('url_custom');
        if($url_custom) {
            $rules['url_custom']  = 'unique:products,url_custom';
        }

        $videoInput = $this->get('videos');

        if(($videoInput)) {
            foreach ($videoInput as $key => $video) {
                $rules['videos.'.$key.'.'.'link']   = 'required';
                $rules['videos.'.$key.'.'.'video']   = 'required';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'aff_link.url' => 'Link affiliate không hợp lệ',
            'short_link.url' => 'Link rút gọn không hợp lệ',
            'origin_link.url' => 'Link gốc không hợp lệ',
            'base_price.min' => 'Giá trước giảm không được nhỏ hơn giá bán',
            'image.max' => 'Ảnh không được lớn hơn 10MB',
            'image.required' => 'Ảnh không được để trống',
            'image.file' => 'Ảnh không hợp lệ',
            'image.mimes' => 'Ảnh không hợp lệ',
            'sku.unique' => 'Mã sản phẩm đã tồn tại',
            'sku.required' => 'Mã sản phẩm không được để trống',
        ];
    }
}
