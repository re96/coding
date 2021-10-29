<?php

namespace App\Domain\User\Exceptions;

use App\Domain\Exception;

class AlreadyExistsEmailException extends Exception
{
    protected $message = '이미 존재하는 이메일입니다.';

    protected $code = 409;
}
