<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 11/11/18
 * Time: 2:51 PM
 */

namespace SmartSms\Exceptions;


use Throwable;

class SmartSmsException extends \Exception
{
    public function __construct(string $message = "Something went wrong with smart sms", int $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}