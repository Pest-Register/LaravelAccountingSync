<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 3:19 PM
 */

namespace PestRegister\LaravelAccountingSync\Models;


use Omnipay\Common\GatewayInterface;
use Omnipay\Omnipay;
use PHPAccounting\PHPAccounting;

class BaseModel
{


    /**
     * Example Xero Config
     *   $config = [
            'xeroConfig' => [
                'type' => 'public',
                'config' => [
                    'oauth' => [
                        'callback' => 'localhost',
                        'signature_method' => \XeroPHP\Remote\OAuth\Client::SIGNATURE_HMAC_SHA1,
                        'consumer_key' => '',
                        'consumer_secret' => '',
                        //If you have issues passing the Authorization header, you can set it to append to the query string
                        'signature_location'    => \XeroPHP\Remote\OAuth\Client::SIGN_LOCATION_QUERY
                        //For certs on disk or a string - allows anything that is valid with openssl_pkey_get_(private|public)
                        'rsa_private_key' => 'file://certs/private.pem',
                        'rsa_public_key' => 'file://certs/public.pem',
                    ]
                ]
            ],
            'accessToken' => '',
            'accessTokenSecret' => '',
            'gateway' => 'xero'
        ];
     */




    private $gateway;

    /**
     * BaseModel constructor.
     * @param $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        $gateway = null;
        $gatewayName = $config['gateway'];

        if($gatewayName == null || strlen($gateway ==0)){
            throw new \Exception('Gateway is not set');
        }

        switch ($gatewayName){
            // only support xero for now
            case "xero":
                $this->gateway = Omnipay::create('\PHPAccounting\Xero\Gateway');
                $this->gateway->setXeroConfig($config['xeroConfig']);
                $this->gateway->setAccessToken($config['accessToken']);
                $this->gateway->setAccessTokenSecret($config['accessTokenSecret']);
                break;
//            case "":
//                break;
//            case "":
            default:
                throw new \Exception('Gateway ' . $gatewayName. ' not supported');
        }
    }

    public function getGateway() {
        return $this->gateway;
    }

}