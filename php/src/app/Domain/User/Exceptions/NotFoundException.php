<?php

namespace App\Domain\User\Exceptions;

use App\Domain\Exception;

class NotFoundException extends Exception
{
    protected $message = '회원 정보를 찾을 수 없습니다.';

    protected $code = 404;
}
