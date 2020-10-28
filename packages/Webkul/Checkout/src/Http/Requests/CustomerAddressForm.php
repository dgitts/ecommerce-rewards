<?php

namespace Webkul\Checkout\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerAddressForm extends FormRequest
{
    protected $rules;

    /**
     * Determine if the product is authorized to make this request.
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

        if (isset($this->get('shipping')['address_id'])) {
            $this->rules = [
                'shipping.address_id' => ['required'],
            ];
        } else {
            $this->rules = [
                'shipping.first_name' => ['required'],
                'shipping.last_name'  => ['required'],
                'shipping.email'      => ['required'],
                'shipping.address1'   => ['required'],
                'shipping.city'       => ['required'],
                'shipping.state'      => ['required'],
                'shipping.postcode'   => ['required'],
                'shipping.phone'      => ['required'],
                'shipping.country'    => ['required'],
            ];
        }

        return $this->rules;
    }
}
