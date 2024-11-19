<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
                        'name'                          =>  'required|max:255',
                        'description.*'                 =>  'nullable',
                        'partner_link'                  =>  'nullable',
                        'partner_image'                  =>  'required',
                        'partner_image.*'                =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'views'                         =>  'nullable', // عدد مرات العرض

                        // used always 
                        'status'             =>  'required',
                        'published_on'       =>  'nullable',
                        'published_on_time'  =>  'nullable',
                        'created_by'         =>  'nullable',
                        'updated_by'         =>  'nullable',
                        'deleted_by'         =>  'nullable',
                        // end of used always 
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'                  =>  'required|max:255',
                        'description.*'           =>  'nullable',
                        'partner_link'           =>  'nullable',
                        'partner_image'                =>  'nullable',
                        'partner_image.*'              =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',

                        // used always 
                        'status'             =>  'required',
                        'published_on'       =>  'nullable',
                        'published_on_time'  =>  'nullable',
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
            'name'                 =>  '(' . __('panel.name') . ')',
            'description'           =>  '(' . __('panel.description') . ')',
            'status'    =>  '( ' . __('panel.status') . ' )',
            'partner_image'    =>  '( ' . __('panel.partner_image') . ' )',
        ];

        return $attr;
    }
}
