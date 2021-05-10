<?php

namespace App\Http\Requests;

use App\Rate;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\OrderService;

class StoreOrderPost extends FormRequest
{
    protected $orderService;

    protected $rate_id = null;

    /**
     * OrderController constructor.
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        parent::__construct();

        $this->orderService = $orderService;
    }

    protected function prepareForValidation()
    {
        $input = $this->all();
        if (isset($input['rate_id'])) {
            $this->rate_id = $input['rate_id'];
        }
    }

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
            'date' => ['required', 'date_format:d.m.Y', function ($attribute, $value, $fail) {
                $rate = Rate::find($this->rate_id);

                if ($rate instanceof Rate) {
                    $allowedDays = json_decode($rate->days);
                    $weekDay = date('w', strtotime($value));

                    if (!in_array($weekDay, $allowedDays)) {
                        $fail('Запрещённый день для данного тарифа');
                    }
                }
            }],
            'address' => ['required', function ($attribute, $value, $fail) {
                $result = $this->orderService->getDadataAddressVariants($value);
                if (empty($result)) {
                    $fail('Неверный адрес');
                }

                if (!in_array($value, $result)) {
                    $fail('Неверный адрес');
                }
            }]
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
