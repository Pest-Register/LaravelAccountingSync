<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 3:19 PM
 */

namespace PestRegister\LaravelAccountingSync\Models;


use PHPAccounting\PHPAccounting;

class BaseModel
{
    private $gateway;
    public function __construct($config)
    {
        $this->gateway = PHPAccounting::create($config['provider']);
        $this->gateway->setAccessToken($config['access_token']);
    }

    public function getGateway(): PHPAccounting{
        return $this->gateway;
    }

}