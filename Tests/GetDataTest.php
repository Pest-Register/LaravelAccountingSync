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
use PestRegister\LaravelAccountingSync\Models\Account;
use PestRegister\LaravelAccountingSync\Models\Contact;
use PestRegister\LaravelAccountingSync\Models\ContactGroup;
use PestRegister\LaravelAccountingSync\Models\InventoryItem;
use PestRegister\LaravelAccountingSync\Models\Invoice;
use PestRegister\LaravelAccountingSync\Models\Journal;
use PestRegister\LaravelAccountingSync\Models\ManualJournal;
use PestRegister\LaravelAccountingSync\Models\Payment;
use PestRegister\LaravelAccountingSync\Models\TaxRate;
use PestRegister\LaravelAccountingSync\Models\TaxRateValue;
use PHPUnit\Framework\TestCase;

class GetDataTest extends TestCase
{
    public function testGetData()
    {
        $provider = 'quickbooks';
        $config = [];

        if ($provider === 'myobaccountright') {
            $page = 1000;
        } else {
            $page = 1;
        }
        $skip = 0;
        try {
            $params = [
                'accounting_id' => "",
                'page' => $page,
            ];
            if ($provider === 'myobaccountright') {
                $params['skip'] = $skip;
            }
            $model = new Entity();
            $collection = $model->getSyncInstance($config)->loadFromAccountingProvider($params);
            do {
                if ($provider === 'myobaccountright') {
                    $page = $page + 1000;
                    $skip = $skip + 1000;
                } elseif ($provider === 'quickbooks') {
                    $page = count($collection) + 1;
                } else {
                    $page = $page + 1;
                }
                $params['page'] = $page;
                $params['skip'] = $skip;
                try {
                    $pagedData = $model->getSyncInstance($config)->loadFromAccountingProvider($params);
                    $collection = array_merge($pagedData, $collection);
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    break;
                }
            } while (true);
            // loop over insert into our database
        } catch (\Exception $exception){
            var_dump($exception->getMessage());
        }
        var_dump('number of entity: '.count($collection));
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
            'name' => '3sfsefe',
            'first_name' => 'test',
            'last_name' => 'account',
            'email_address' => 'test@test.com'
        ];
    }

    protected $accountingResource = Contact::class;

    public function parseAccountingArray($data = [])
    {
        // TODO: Implement parseAccountingArray() method.
    }
}