<?php

namespace App\Http\Requests\Api\Events;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:191|required',
            'color' => 'max:191',
            'priority' => 'integer',
            'description' => 'max:191',
            'url' => 'max:191',
            'reminder' => 'boolean',
//            'reminder_at' => 'date_format:H:i:s',
        ];
    }
}
