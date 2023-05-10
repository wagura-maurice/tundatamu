<?php

namespace App\Http\Requests;

use App\Models\TextMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class TextMessageFormRequest extends FormRequest
{    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        // return Gate::allows('issue_management');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = TextMessage::createRules();

        if (request()->method == 'PUT' || request()->method == 'PATCH') {
            $rules = array_merge($rules, TextMessage::updateRules(request()->route()->originalParameters()['textMessage']));
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if(request()->route()->originalParameters()) {
            $this->merge(array_filter([]));
        } else {
            $this->merge(array_filter([
                '_pid' => generatePID(TextMessage::class)
            ]));
        }
    }
}
