<?php

namespace App\Domain\User\Exceptions;

use App\Domain\Exception;

class RegisterException extends Exception
{
    protected $message = '회원 등록에 실패했습니다.';

    protected $code = 500;
}
