<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CreateUserRequest extends Request
{
    /**
     * 적용될 유효성 검사 규칙을 반환합니다.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:20',
                'regex:/^[\pL\pMa-zA-Z]+$/u',
            ],
            'nickname' => [
                'required',
                'max:30',
                'regex:/^[a-z]+$/',
            ],
            'password' => [
                'required',
                'min:10',
                'regex:/^.*(?=.{4,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\pZ\pS\pP]).*$/u',
            ],
            'phone' => [
                'required',
                'max:20',
                'regex:/^[0-9]+$/'
            ],
            'email' => [
                'required',
                'max:100',
                'regex:/^[0-9a-zA-Z-_\.]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z0-9]{2,}$/i',
            ],
            'gender' => [
                'nullable',
                Rule::in(['M', 'F']),
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
        return [
            'name.required' => '이름은 필수 입력 항목입니다.',
            'name.max' => '이름은 최대 :max자 까지만 가능합니다.',
            'name.regex' => '이름은 한글, 영문 대소문자만 가능합니다.',

            'nickname.required' => '별명은 필수 입력 항목입니다.',
            'nickname.max' => '별명은 최대 :max자 까지만 가능합니다.',
            'nickname.regex' => '별명은 영문 소문자만 가능합니다.',

            'password.required' => '비밀번호는 필수 입력 항목입니다.',
            'password.min' => '비밀번호는 최소 :min자 이상만 가능합니다.',
            'password.regex' => '비밀번호는 영문 대문자, 영문 소문자, 특수 문자, 숫자를 각 1개 이상씩 포함해야 합니다.',

            'phone.required' => '전화번호는 필수 입력 항목입니다.',
            'phone.max' => '전화번호는 최대 :max자 까지만 가능합니다.',
            'phone.regex' => '전화번호는 숫자만 입력 가능합니다.',

            'email.required' => '이메일은 필수 입력 항목입니다',
            'email.max' => '이메일은 최대 :max자 까지만 가능합니다.',
            'email.regex' => '이메일 형식이 올바르지 않습니다.',

            'gender.in' => '성별은 남자(M)와 여자(F)만 입력 가능합니다.',
        ];
    }
}
