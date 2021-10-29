<?php

namespace App\Domain\Order\Exceptions;

use App\Domain\Exception;

class RegisterException extends Exception
{
    protected $message = '주문 등록에 실패했습니다.';

    protected $code = 500;
}
