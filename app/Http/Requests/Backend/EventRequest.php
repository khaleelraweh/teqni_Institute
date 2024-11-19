<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
                        // 'title.*'               =>  'required|max:255|unique_translation:posts',
                        'title.*'                           =>  'required|max:255',
                        'content.*'                         =>  'nullable',

                        'metadata_title.*'                  =>  'nullable',
                        'metadata_description.*'            =>  'nullable',
                        'metadata_keywords.*'               =>  'nullable',

                        'start_date'                        =>  'nullable',
                        'end_date'                          =>  'nullable',
                        'start_time'                        =>  'nullable',
                        'end_time'                          =>  'nullable',

                        'status'                            =>  'required',
                        'tags.*'                            =>  'required',
                        'images'                            =>  'required',
                        'images.*'                          =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'created_by'                        =>  'nullable',
                        'updated_by'                        =>  'nullable',
                        'deleted_by'                        =>  'nullable',
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        // 'title.*'               =>  'required|max:255|unique_translation:posts,title,' . $this->route()->post,
                        'title.*'                           =>  'required|max:255',
                        'content.*'                         =>  'nullable',

                        'metadata_title.*'                  =>  'nullable',
                        'metadata_description.*'            =>  'nullable',
                        'metadata_keywords.*'               =>  'nullable',

                        'start_date'                        =>  'nullable',
                        'end_date'                          =>  'nullable',
                        'start_time'                        =>  'nullable',
                        'end_time'                          =>  'nullable',

                        'status'                            =>  'required',
                        'tags.*'                            =>  'required',
                        'images'                            =>  'nullable',
                        'images.*'                          =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'created_by'                        =>  'nullable',
                        'updated_by'                        =>  'nullable',
                        'deleted_by'                        =>  'nullable',
                    ];
                }

            default:
                break;
        }
    }

    public function attributes(): array
    {
        $attr = [
            'images'      => '( ' . __('panel.images') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.title')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
            $attr += ['content.' . $key       =>  "( " . __('panel.content')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }

        return $attr;
    }
}
