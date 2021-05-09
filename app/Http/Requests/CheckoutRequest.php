<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if ($request->stripeToken) {
            return [
                'email' => 'required|email',
                'phone' => 'required',
                'full_name' => 'required',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'zip' => 'required',
                'card_holder_name' => 'required'

            ];
        } else {
            return [
                'email' => 'required|email',
                'phone' => 'required',
                'full_name' => 'required',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'zip' => 'required',

            ];
        }
    }
}
