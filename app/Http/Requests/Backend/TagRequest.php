<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
    { {
            switch ($this->method()) {
                case 'POST': {
                        return [
                            'name.ar'          =>  'required|max:255|unique_translation:tags',
                            'section'       =>  'nullable',

                            // used always 
                            'status'             =>  'required',
                            'published_on'              =>  'required',
                            'created_by'         =>  'nullable',
                            'updated_by'         =>  'nullable',
                            'deleted_by'         =>  'nullable',
                            // end of used always 
                        ];
                    }
                case 'PUT':
                case 'PATCH': {
                        return [
                            'name.ar'       => 'required|max:255|unique_translation:tags,name,' . $this->route()->tag,
                            'section'    => 'nullable',

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
    }

    public function attributes(): array
    {

        $attr = [
            'status'            =>  '( ' . __('panel.status') . ' )',
            'published_on'      => '( ' . __('panel.published_on') . ' )',

        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['name.' . $key       =>  "( " . __('panel.tag_name')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }

        return $attr;
    }
}
