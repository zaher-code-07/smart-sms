<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 11/12/18
 * Time: 11:16 AM
 */

namespace SmartSms\Driver;


use SmartSms\Contracts\DriverContract;
use SmartSms\Exceptions\SmartSmsException;

abstract class Driver implements DriverContract
{
    protected $recipients = [];
    protected $message;

    public function to($recipients): DriverContract
    {
        $recipients = \is_array($recipients) ? $recipients : [$recipients];

        $recipients = \array_map(function ($recipient) {
            return \trim($recipient);
        }, \array_merge($this->recipients, $recipients));

        $this->recipients = \array_values(\array_filter($recipients));

        return $this;
    }

    /**
     * Set text message body.
     *
     * @param $message string
     * @return $this
     * @throws \Exception
     */
    public function message($message)
    {
        if (!is_string($message)) {
            throw new SmartSmsException("Message text should be a string.");
        }
        if (trim($message) == '') {
            throw new SmartSmsException("Message text could not be empty.");
        }
        $this->message = $message;
        return $this;
    }

}