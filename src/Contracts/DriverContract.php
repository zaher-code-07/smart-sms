<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 11/12/18
 * Time: 11:41 AM
 */

namespace MoeenBasra\SmartSms\Contracts;


interface DriverContract
{
    public function __construct($config);

    public function send();

    public function to($recipients): self;
}