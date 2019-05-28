<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 27/05/2019
 * Time: 11:41 AM
 */

namespace PestRegister\LaravelAccountingSync\Tests;

use Faker\Generator;
use PestRegister\LaravelAccountingSync\AccountingEntity;
use PestRegister\LaravelAccountingSync\Models\Customer;
use PHPUnit\Framework\TestCase;

class GetDataTest extends TestCase
{
    public function testGetContacts()
    {
        $config = [
            'xeroConfig' => [
                'type' => 'public',
                'config' => [
                    'oauth' => [
                        'callback' => 'localhost',
                        'signature_method' => 'HMAC-SHA1',
                        'consumer_key' => 'LEFVEZ26CAJQXOBLKNZGE5KDAY2HP3',
                        'consumer_secret' => 'LIYZTFSOCIIZUWEYIQBVPHJS8VG39D',
                        //If you have issues passing the Authorization header, you can set it to append to the query string
                        'signature_location'    => 'query_string',
                        //For certs on disk or a string - allows anything that is valid with openssl_pkey_get_(private|public)
                    ]
                ]
            ],
            'accessToken' => 'BEUH7PDY4BLBZWZUJVDCN0OEHH3TDN',
            'accessTokenSecret' => 'ZQTAEPFBNCRUYVBCPNWAKAZFSYVKJC',
            'gateway' => 'xero'
        ];
        try {
            $model = new Entity();
            $data = $model->getSyncInstance($config)->syncToAccountingProvider();
            var_dump($data);
            // loop over insert into our database
        } catch (\Exception $exception){
            var_dump($exception->getMessage());
            var_dump($exception->getTrace());
        }
    }
}

class Entity extends AccountingEntity {

    /**
     * The data to sync to Accounting.
     *
     * @see https://developer.intuit.com/docs/api/accounting
     * @return array
     */
    public function getAccountingArray(): array
    {

        return [
            'name' => 'test account',
            'first_name' => 'test',
            'last_name' => 'account',
            'email_address' => 'test@test.com'
        ];
    }

    protected $accountingResource = Customer::class;
}