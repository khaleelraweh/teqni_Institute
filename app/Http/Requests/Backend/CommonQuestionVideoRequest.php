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
                        'title.*'               => 'required|unique_translation:common_question_videos',
                        'link.*'                => 'required',
                        'question_video_image'  => 'nullable|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                =>  'required',
                        'created_by'            =>  'nullable',
                        'updated_by'            =>  'nullable',
                        'deleted_by'            =>  'nullable',
                        // end of used always 

                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title.*'               => 'required|max:255|unique_translation:common_question_videos,title,' . $this->route()->common_question_video,
                        'link.*'                => 'required',
                        'question_video_image'  => 'nullable|mimes:jpg,jpeg,png,svg,gif,webp|max:3000',

                        // used always 
                        'status'                =>  'required',
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
}
