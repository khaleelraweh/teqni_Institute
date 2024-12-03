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
                        'name.ar'                          =>  'required|max:255',
                        'description.*'                 =>  'nullable',
                        'partner_link.*'                  =>  'nullable',
                        'partner_image'                  =>  'required',
                        'partner_image.*'                =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',
                        'views'                         =>  'nullable', // عدد مرات العرض

                        'metadata_title.*'              =>  'nullable',
                        'metadata_description.*'        =>  'nullable',
                        'metadata_keywords.*'           =>  'nullable',

                        // used always 
                        'status'             =>  'required',
                        'published_on'       =>  'required',
                        'created_by'         =>  'nullable',
                        'updated_by'         =>  'nullable',
                        'deleted_by'         =>  'nullable',
                        // end of used always 
                    ];
                }
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name.ar'                  =>  'required|max:255',
                        'description.*'           =>  'nullable',
                        'partner_link.*'           =>  'nullable',
                        'partner_image'                =>  'nullable',
                        'partner_image.*'              =>  'mimes:jpg,jpeg,png,gif,webp|max:3000',

                        'metadata_title.*'              =>  'nullable',
                        'metadata_description.*'        =>  'nullable',
                        'metadata_keywords.*'           =>  'nullable',

                        // used always 
                        'status'             =>  'required',
                        'published_on'       =>  'required',
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
            'partner_image'      => '( ' . __('panel.images') . ' )',
            'status'    =>  '( ' . __('panel.status') . ' )',
            'published_on'      => '( ' . __('panel.published_on') . ' )',

        ];

        foreach (config('locales.languages') as $key => $val) {
            $attr += ['name.' . $key       =>  "( " . __('panel.name')   . ' ' . __('panel.in') . ' ' . __('panel.' . $val['lang'])   . " )",];
        }


        return $attr;
    }
}
