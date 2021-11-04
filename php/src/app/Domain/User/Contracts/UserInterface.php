<?php

namespace App\Domain\User\Contracts;

interface UserInterface
{
    /**
     * 회원의 주문 정보를 반환합니다.
     */
    public function orders();

    /**
     * 회원의 가장 최근 주문 정보를 반환합니다.
     */
    public function latestOrder();
}
