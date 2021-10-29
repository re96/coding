<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CreateOrderRequest extends Request
{
    /**
     * 적용될 유효성 검사 규칙을 반환합니다.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => [
                'required',
                'max:100',
            ],
            'paid_at' => [
                'required',
                'date',
            ],
        ];
    }

    /**
     * 적용될 유효성 검사 메세지를 반환합니다.
     *
     * @return array
     */
    public function messages()
    {
        $now = Carbon::now();

        return [
            'product_name.required' => '제품명은 필수 입력 항목입니다.',
            'product_name.max' => '제품명은 최대 :max자 까지만 가능합니다.',

            'paid_at.required' => '결제일시는 필수 입력 항목입니다.',
            'paid_at.date' => '결제일시는 일시 형태만 가능합니다. (ex. '.($now->toDateTimeString()).' / '.($now->tz('UTC')->toIso8601ZuluString()).')',
        ];
    }
}
