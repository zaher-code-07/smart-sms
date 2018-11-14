<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 11/13/18
 * Time: 10:00 AM
 */

namespace MoeenBasra\SmartSms\Facade;


use Illuminate\Support\Facades\Facade;

class Sms extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'sms';
    }
}