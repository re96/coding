<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * 적용될 유효성 검사 규칙을 반환합니다.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
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
            'email.required' => '이메일은 필수 입력 항목입니다.',
            'password.required' => '비밀번호는 필수 입력 항목입니다.',
        ];
    }
}
