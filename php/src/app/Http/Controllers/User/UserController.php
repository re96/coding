<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\CreateUserRequest;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\User\Resources\UserResource;

class UserController extends Controller
{
    /**
     * 회원 목록을 조회합니다.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // 페이지당 조회할 회원 수
        $perpage = max(1, $request->input('perpage') ?: 20);
        // 회원 이름
        $name = $request->input('name');
        // 회원 이메일
        $email = $request->input('email');

        // Repository 설정
        $userRepository = new UserRepository;

        // 정렬 순서 설정
        $userRepository->orderBy('latest');

        // 회원별 최근 주문 정보
        $userRepository->withLatestOrder();

        // 이름 검색
        if ($name !== null) {
            $userRepository->filterByName($name);
        }
        // 이메일 검색
        if ($email !== null) {
            $userRepository->filterByEmail($email);
        }

        // 회원 조회 결과 데이터
        $users = $userRepository->paginate($perpage);

        // 회원 리소스의 데이터화
        $data = UserResource::collection($users)->toArray($request);

        return $this->response([
            'total' => $users->total(),
            'data' => $data,
        ], 200);
    }

    /**
     * 회원을 생성합니다.
     *
     * @param  \App\Http\Requests\User\CreateUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        // Repository 설정
        $userRepository = new UserRepository;
        $user = $userRepository->create($request->all());

        $data = new UserResource($user);

        return $this->response([
            'message' => '회원 가입이 완료되었습니다.',
            'data' => $data,
        ], 201);
    }
}
