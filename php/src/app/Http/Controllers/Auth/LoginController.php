<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\User\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * 회원 인증 후 토큰을 반환합니다.
     *
     * @param  App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only([
            'email',
            'password',
        ]);

        // Repository 설정
        $userRepository = new UserRepository;

        $user = $userRepository->attempt($credentials);

        if ($user) {
            $token = $user->createToken('login')->accessToken;
            return $this->response([
                'access_token' => $token,
            ], 200);
        }

        return $this->response([
            'message' => '이메일 또는 비밀번호가 일치하지 않습니다.',
        ], 401);
    }

    /**
     * 회원 로그아웃
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->token()->revoke();
            return $this->response([
                'message' => '로그아웃이 완료되었습니다.',
            ], 200);
        }

        return $this->response([
            'message' => '회원 정보를 찾을 수 없습니다.',
        ], 401);
    }
}
