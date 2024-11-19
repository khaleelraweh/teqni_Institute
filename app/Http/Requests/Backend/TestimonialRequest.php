<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST': {
                    return [
                        'name.*'                    => 'required|unique_translation:testimonials',
                        'title.*'                   => 'required',
                        'content.*'                 => 'required',
                        'image'                     => 'nullable|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                    =>  'required',
                        'created_by'                =>  'nullable',
                        'updated_by'                =>  'nullable',
                        'deleted_by'                =>  'nullable',
                        // end of used always 

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name.*'                    => 'required|max:255|unique_translation:testimonials,name,' . $this->route()->testimonial,
                        'title.*'                   => 'required',
                        'content.*'                 => 'required',
                        'image'                     => 'nullable|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                    =>  'required',
                        'created_by'                =>  'nullable',
                        'updated_by'                =>  'nullable',
                        'deleted_by'                =>  'nullable',
                        // end of used always 

                    ];
                }

            default:
                break;
        }
    }
}
