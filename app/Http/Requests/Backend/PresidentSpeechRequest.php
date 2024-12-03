<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PresidentSpeechRequest extends FormRequest
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
                        'title.*'       =>  'required|max:255',
                        'content.*'     =>  'nullable',
                        'promotional_image' => 'required|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',


                        // used always 
                        'status'             =>  'required',
                        'published_on'                      =>  'required',
                        'created_by'         =>  'nullable',
                        'updated_by'         =>  'nullable',
                        'deleted_by'         =>  'nullable',
                        // end of used always 

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title.*'           =>   'required|max:255',
                        'content.*'         =>   'nullable',
                        'promotional_image' => 'required|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',


                        // used always 
                        'status'             =>  'required',
                        'published_on'                      =>  'required',
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
            'promotional_image'      => '( ' . __('panel.image') . ' )',
            'published_on'      => '( ' . __('panel.published_on') . ' )',
        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.title')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
