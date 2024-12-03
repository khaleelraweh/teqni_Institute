<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class MainSliderRequest extends FormRequest
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
                        'title.ar'               =>  'required|max:255|unique_translation:sliders',
                        'subtitle.*'            =>  'nullable',
                        'description.*'         =>  'nullable',
                        'url'                   =>  'nullable',
                        'btn_title'             =>  'nullable',
                        'show_btn_title'    =>  'required',
                        'target'                =>  'required',
                        'section'               =>  'nullable',
                        'show_info'              =>  'required',
                        'images'                =>  'required',
                        'images.*'              =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',

                        'metadata_title.*'              =>  'nullable',
                        'metadata_description.*'        =>  'nullable',
                        'metadata_keywords.*'           =>  'nullable',

                        // used always 
                        'status'                =>  'required',
                        'published_on'              =>  'required',
                        'created_by'            =>  'nullable',
                        'updated_by'            =>  'nullable',
                        'deleted_by'            =>  'nullable',
                        // end of used always 
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title.ar'           =>  'required|max:255|unique_translation:sliders,title,' . $this->route()->main_slider,
                        'subtitle.*'        =>  'nullable',
                        'description.*'     =>  'nullable',
                        'url'               =>  'nullable',
                        'btn_title'         =>  'nullable',
                        'show_btn_title'    =>  'required',
                        'target'            =>  'nullable',
                        'section'           =>  'nullable',
                        'show_info'          => 'required',
                        'images'            =>  'nullable',
                        'images.*'          =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',

                        'metadata_title.*'              =>  'nullable',
                        'metadata_description.*'        =>  'nullable',
                        'metadata_keywords.*'           =>  'nullable',

                        // used always 
                        'status'             =>  'required',
                        'published_on'              =>  'required',
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
            'link'      => '( ' . __('panel.link') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
            'published_on'      => '( ' . __('panel.published_on') . ' )',

        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.title')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
            $attr += ['description.' . $key       =>  "( " . __('panel.description')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }

        return $attr;
    }
}
