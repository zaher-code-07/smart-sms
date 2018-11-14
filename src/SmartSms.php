<?php
/**
 * Created by PhpStorm.
 * User: moeen
 * Date: 11/11/18
 * Time: 2:44 PM
 */

namespace SmartSms;


use SmartSms\Contracts\DriverContract;
use SmartSms\Exceptions\SmartSmsException;

class SmartSms
{
    /**
     * SMS Configuration
     *
     * @var null | array
     */
    protected $config;

    /**
     * SMS Driver settings
     *
     * @var null | array
     */
    protected $settings;

    /**
     * SMS Driver name
     * @var mixed
     */
    protected $driver;

    public function __construct()
    {
        $this->config = config('sms');
        $this->driver = $this->config['default'];
        $this->settings = $this->config['drivers'][$this->driver];
    }

    public function with($driver): SmartSms
    {
        $this->driver = $driver;
        $this->settings = $this->config['drivers'][$this->driver];

        return $this;
    }

    public function send($message, $to)
    {
        // validate paramaters
        $this->validateParams();

        // load drivers
        $class = $this->config['map'][$this->driver];

        // create new instance with settings
        /** @var DriverContract $instance */
        $instance = new $class($this->settings);

        $instance->message($message);

        if (is_callable($to)) {
            call_user_func($to, $instance);
        } else {
            $instance->to($to);
        }

        return $instance->send();
    }

    protected function validateParams()
    {
        if (empty($this->driver)) {
            throw new SmartSmsException('Invalid sms drivers');
        }

        if (empty($this->config['drivers'][$this->driver]) or empty($this->config['map'][$this->driver])) {
            throw new SmartSmsException('Driver not found in config file. Try updating the package.');
        }

        if (!class_exists($this->config['map'][$this->driver])) {
            throw new SmartSmsException('Driver source not found. Please update the package.');
        }
    }
}