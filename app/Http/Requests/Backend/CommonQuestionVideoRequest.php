<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CommonQuestionVideoRequest extends FormRequest
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
                        'title.ar'               => 'required|unique_translation:common_question_videos',
                        'link.ar'                => 'required',
                        'question_video_image'  => 'required|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                =>  'required',
                        'published_on'                      =>  'required',
                        'created_by'            =>  'nullable',
                        'updated_by'            =>  'nullable',
                        'deleted_by'            =>  'nullable',
                        // end of used always 

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title.ar'               => 'required|max:255|unique_translation:common_question_videos,title,' . $this->route()->common_question_video,
                        'link.ar'                => 'required',
                        'question_video_image'  => 'required|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                =>  'required',
                        'published_on'                      =>  'required',
                        'created_by'            =>  'nullable',
                        'updated_by'            =>  'nullable',
                        'deleted_by'            =>  'nullable',
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
            'status'    =>  '( ' . __('panel.status') . ' )',
            'published_on'      => '( ' . __('panel.published_on') . ' )',
            'question_video_image'      => '( ' . __('panel.images') . ' )',

        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['title.' . $key       =>  "( " . __('panel.title')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
            $attr += ['description.' . $key       =>  "( " . __('panel.description')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
