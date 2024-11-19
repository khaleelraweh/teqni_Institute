<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PageCategoryRequest extends FormRequest
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
                        'title.*'                   =>  'required|max:255',
                        'content.*'                 =>  'nullable',
                        'metadata_title.*'          =>  'nullable',
                        'metadata_description.*'    =>  'nullable',
                        'metadata_keywords.*'       =>  'nullable',
                        'images'                    =>  'required',
                        'images.*'                  =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',

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
                        'title.*'                   =>   'required|max:255',
                        'content.*'                 =>   'nullable',
                        'metadata_title.*'          =>  'nullable',
                        'metadata_description.*'    =>  'nullable',
                        'metadata_keywords.*'       =>  'nullable',
                        'images.*'                  =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',


                        // used always 
                        'status'             =>  'required',
                        'created_by'         =>  'nullable',
                        'updated_by'         =>  'nullable',
                        'deleted_by'         =>  'nullable',
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
            'content'      => '( ' . __('panel.f_content') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.title')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
