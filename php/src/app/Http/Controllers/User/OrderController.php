<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Domain\User\Repositories\UserRepository;
use App\Domain\Order\Repositories\OrderRepository;
use App\Domain\Order\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * @var \App\Domain\User\Models\User
     */
    protected $user;

    /**
     * Constructor
     *
     * @param Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        $user_id = $this->interceptParameter('user_id');

        if ($user_id) {
            $userRepository = new UserRepository;
            $this->user = $userRepository->findOrFail($user_id);
        } else {
            $this->user = null;
        }

        parent::__construct();
    }

    /**
     * 회원의 주문 목록을 조회합니다.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Repository 설정
        $orderRepository = new OrderRepository($this->user);

        // 정렬 순서 설정
        $orderRepository->orderBy('latest');

        // 주문 조회 결과 데이터
        $orders = $orderRepository->get();

        // 주문 리소스의 데이터화
        $data = OrderResource::collection($orders)->toArray($request);

        return $this->response([
            'data' => $data,
        ], 200);
    }

    /**
     * 회원의 주문을 생성합니다.
     *
     * @param  \App\Http\Requests\Order\CreateOrderRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        // Repository 설정
        $orderRepository = new OrderRepository($this->user);
        $order = $orderRepository->create($request->all());

        // 주문번호를 DB에서 생성했기 때문에 주문 정보를 재조회
        $order = $orderRepository->findOrFail($order->id);

        // 주문 리소스의 데이터화
        $data = new OrderResource($order);

        return $this->response([
            'message' => '주문 등록이 완료되었습니다.',
            'data' => $data,
        ], 201);
    }

    /**
     * 회원의 주문을 조회합니다.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, int $order_id)
    {
        // Repository 설정
        $orderRepository = new OrderRepository($this->user);

        // 상세 주문 정보 조회
        $order = $orderRepository->findOrFail($order_id);

        // 주문 리소스의 데이터화
        $data = new OrderResource($order);

        return $this->response([
            'data' => $data,
        ], 200);
    }
}
