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


    private $allowedGateways = [
        'xero',
        'myobaccountright',
        'myobessentials',
        'quickbooks'
    ];

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

        if(!$this->isGatewayAllowed($gatewayName)){
            throw new \Exception('Gateway is not set or is not allowed');
        }

        switch ($gatewayName){
            case "xero":
                $this->gateway = Omnipay::create('\PHPAccounting\Xero\Gateway');
                $this->gateway->setAccessToken($config['accessToken']);
                $this->gateway->setClientID($config['clientID']);
                $this->gateway->setClientSecret($config['clientSecret']);
                $this->gateway->setTenantID($config['tenantID']);
                $this->gateway->setCallbackURL($config['callbackURL']);
                break;
            case "myobaccountright":
                $this->gateway = Omnipay::create('\PHPAccounting\MyobAccountRight\Gateway');
                $this->gateway->setAPIKey($config['apiKey']);
                $this->gateway->setAccessToken($config['accessToken']);
                $this->gateway->setCompanyEndpoint($config['companyEndpoint']);
                $this->gateway->setCompanyFile($config['companyFile']);
                break;
            case "myobessentials":
                $this->gateway = Omnipay::create('\PHPAccounting\MyobEssentials\Gateway');
                $this->gateway->setApiKey($config['apiKey']);
                $this->gateway->setAccessToken($config['accessToken']);
                $this->gateway->setBusinessID($config['businessID']);
                $this->gateway->setCountryCode($config['countryCode']);
                break;
            case "quickbooks":
                $this->gateway = Omnipay::create('\PHPAccounting\Quickbooks\Gateway');
                $this->gateway->setClientID($config['clientID']);
                $this->gateway->setClientSecret($config['clientSecret']);
                $this->gateway->setAccessToken($config['accessToken']);
                $this->gateway->setQBORealmID($config['qboRealmID']);
                $this->gateway->setBaseURL($config['baseUrl']);
                break;

            default:
                throw new \Exception('Gateway ' . $gatewayName. ' not supported');
        }
    }

    public function getGateway() {
        return $this->gateway;
    }

    private function isGatewayAllowed($gateway){
        return in_array($gateway, $this->allowedGateways);
    }

}