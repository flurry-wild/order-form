<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderPost extends FormRequest
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
            'phone' => 'required|max:12|regex:/^\+7[0-9]{10}$/',
            'name' => 'required|max:60|string',
            'rate_id' => 'required|integer|exists:rates,id',
            'date' => 'required|date_format:d.m.Y',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Не указан телефон',
            'phone.regex' => 'Неверный формат номера',
            'name.required' => 'Не указано имя',
            'rate_id.required' => 'Не указан тариф',
            'rate_id.integer' => 'Тариф должен быть числом',
            'rate_id.exists' => 'Такого тарифа не существует',
            'date.required' => 'Не указана дата',
            'date.date_format' => 'Неверный формат даты',
            'address.required' => 'Не указан адрес',
            'max' => 'Слишком большое количество символов'
        ];
    }
}
