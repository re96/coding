<?php

namespace App\Domain\User\Repositories;

use App\Domain\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Domain\User\Models\User;
use App\Domain\User\Exceptions\AlreadyExistsEmailException;
use App\Domain\User\Exceptions\RegisterException;
use App\Domain\User\Exceptions\NotFoundException;
use Exception;

class UserRepository extends Repository
{
    /**
     * 모델을 설정합니다.
     */
    public function model()
    {
        return new User;
    }

    /**
     * 회원을 생성합니다.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return DB::transaction(function() use ($data) {

            // 이메일이 이미 존재할 경우 예외 처리
            $exist = $this->model->where('email', $data['email'])->count();
            if ($exist) {
                throw new AlreadyExistsEmailException;
            }

            try {

                // 비밀번호를 암호화합니다.
                $data['password'] = bcrypt($data['password']);

                // 데이터를 테이블에 생성하고 반환합니다.
                return $this->model->create($data);

            } catch (Exception $e) {

                throw new RegisterException;

            }
        });
    }

    /**
     * 최근 주문 정보를 연동합니다.
     *
     * @return $this
     */
    public function withLatestOrder()
    {
        $this->model = $this->model->with('latestOrder');

        return $this;
    }

    /**
     * 회원을 아이디로 조회하여 반환합니다.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model $model
     */
    public function findOrFail(int $id)
    {
        $user = $this->model->find($id);
        if (!$user) {
            throw new NotFoundException;
        }

        return $user;
    }

    /**
     * 회원 인증을 시도합니다.
     *
     * @param  array  $params
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function attempt(array $params)
    {
        $model = $this->getModel();

        foreach ($params as $key => $val) {
            if ($key !== 'password') {
                $model = $model->where($key, $val);
            }
        }

        $users = $model->get();

        if (array_key_exists('password', $params)) {
            foreach ($users as $user) {
                // 비밀번호 확인
                if (Hash::check($params['password'], $user->password)) {
                    return $user;
                }
            }
            return null;
        }

        return $users->first();
    }

    /**
     * 회원 이름으로 필터링합니다.
     *
     * @param  string  $name
     * @return $this
     */
    public function filterByName($name)
    {
        $this->model = $this->model->where('name', $name);

        return $this;
    }

    /**
     * 회원 이메일로 필터링합니다.
     *
     * @param  string  $email
     * @return $this
     */
    public function filterByEmail($email)
    {
        $this->model = $this->model->where('email', $email);

        return $this;
    }

    /**
     * 정렬 순서를 설정합니다.
     *
     * @param  string  $key
     * @return $this
     */
    public function orderBy($key)
    {
        switch ($key) {
            case 'latest':
                $this->model = $this->model->orderBy('created_at', 'desc')
                                           ->orderBy('id', 'desc');
                break;
        }

        return $this;
    }
}
