<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2015/7/1
 * Time: 15:36
 * Email: 2034906607@qq.com
 */

namespace App\Lib\Express;


abstract class Contracts
{
    protected $name = 'some_express';
    protected $code = 'code';
    protected $version = '1.0.0';
    protected $desc = 'express_desc';
    protected $cod = false;
    protected $auth = "wang";
    protected $website = "https://github/Dearmadman";
    protected $email = "2034906607@qq.com";
    protected $config = [];

    abstract function settleAccount($amount, $number, $weight);

    public function __set($key, $value)
    {
        $this->config[$key] = $value;
    }

    public function __get($key)
    {
        if (property_exists(self::class, $key)) {
            return $this->$key;
        }
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return '';
    }

}