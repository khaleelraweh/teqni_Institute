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
                        'name.ar'                    => 'required|unique_translation:testimonials',
                        'title.ar'                   => 'required',
                        'content.ar'                 => 'required',
                        'image'                     => 'required|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                    =>  'required',
                        'published_on'                      =>  'required',
                        'created_by'                =>  'nullable',
                        'updated_by'                =>  'nullable',
                        'deleted_by'                =>  'nullable',
                        // end of used always 

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name.ar'                    => 'required|max:255|unique_translation:testimonials,name,' . $this->route()->testimonial,
                        'title.ar'                   => 'required',
                        'content.ar'                 => 'required',
                        'image'                     => 'required|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                    =>  'required',
                        'published_on'                      =>  'required',
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

    public function attributes(): array
    {
        $attr = [
            'image'      => '( ' . __('panel.image') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
            'published_on'      => '( ' . __('panel.published_on') . ' )',

        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.title')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
            $attr += ['name.' . $key       =>  "( " . __('panel.name')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
            $attr += ['content.' . $key       =>  "( " . __('panel.f_content')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
