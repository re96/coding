<?php

namespace App\Domain\Order\Repositories;

use App\Domain\Repository;
use Illuminate\Support\Facades\DB;
use App\Domain\User\Contracts\UserInterface;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Exceptions\RegisterException;
use App\Domain\Order\Exceptions\NotFoundException;
use Carbon\Carbon;
use Exception;

class OrderRepository extends Repository
{
    /**
     * @var \App\Domain\User\Contracts\UserInterface
     */
    protected $user;

    /**
     * Constructor
     *
     * @param App\Domain\User\Contracts\UserInterface|null  $user
     */
    public function __construct(UserInterface $user = null)
    {
        $this->user = $user;

        parent::__construct();
    }

    /**
     * 모델을 설정합니다.
     */
    public function model()
    {
        return $this->user ? $this->user->orders() : new Order;
    }

    /**
     * 주문을 생성합니다.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return DB::transaction(function() use ($data) {

            try {

                // 주문번호 생성
                // timestamp 60bit를 36진수로 변환
                $data['ord_no'] = DB::raw('lpad(conv(concat(substr(uuid(), 16, 3), substr(uuid(), 10, 4), substr(uuid(), 1, 8)), 16, 36), 12, 0)');

                // 결제일시를 UTC 기준으로 변경
                // ex. paid_at = 2021-10-29T13:04:12.000Z 로 입력되었을 경우
                //     paid_at = 2021-10-29 22:04:12 로 변환 (서버 timezone이 Asia/Seoul로 설정된 경우)
                $data['paid_at'] = Carbon::create($data['paid_at'])->tz(config('app.timezone'));
                // UTC로 시간을 변경 후 DB 서버에서 맞추는 방법
                // $data['paid_at'] = Carbon::create($data['paid_at'])->tz('UTC')->format('Y-m-d H:i:s');
                // $data['paid_at'] = DB::raw('convert_tz(\''.$data['paid_at'].'\', \'+00:00\', \'SYSTEM\')');

                // 데이터를 테이블에 생성하고 반환합니다.
                return $this->model->create($data);

            } catch (Exception $e) {

                throw new RegisterException;

            }
        });
    }

    /**
     * 주문을 아이디로 조회하여 반환합니다.
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
