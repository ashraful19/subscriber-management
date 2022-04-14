<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriberRequest extends FormRequest
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
        $subscriber = $this->route('subscriber');
        return [
            'name' => 'required|min:3',
            'email' => 'required|email:rfc,dns|unique:subscribers,email,'.$subscriber->id,
            'state' => 'required'
        ];
    }
}
