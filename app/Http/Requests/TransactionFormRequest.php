<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;

class TransactionFormRequest extends FormRequest
{   
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        // return Gate::allows('transaction_management');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Transaction::createRules();

        if (request()->method == 'PUT' || request()->method == 'PATCH') {
            $rules = array_merge($rules, Transaction::updateRules(request()->route()->originalParameters()['transaction']));
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
            $this->merge(array_filter([
                'transaction_code' => $this->transaction_code ? collect($this->transaction_code)->toJson() : NULL
            ]));
        } else {
            $this->merge(array_filter([
                '_pid' => generatePID(Transaction::class, 10),
                'transaction_code' => $this->transaction_code ? collect($this->transaction_code)->toJson() : NULL
            ]));
        }
    }
}
