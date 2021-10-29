<?php

namespace App\Domain\Order\Exceptions;

use App\Domain\Exception;

class NotFoundException extends Exception
{
    protected $message = '주문 정보를 찾을 수 없습니다.';

    protected $code = 404;
}
