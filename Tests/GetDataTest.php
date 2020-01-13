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
use PestRegister\LaravelAccountingSync\Models\Contact;
use PestRegister\LaravelAccountingSync\Models\Invoice;
use PestRegister\LaravelAccountingSync\Models\ManualJournal;
use PestRegister\LaravelAccountingSync\Models\Payment;
use PHPUnit\Framework\TestCase;

class GetDataTest extends TestCase
{
    public function testGetContacts()
    {
        $config = [];
        $page = 1;
        try {
            $params = [
                'accounting_ids' => [""],
                'page' => $page,
            ];
            $model = new Entity();
            $collection = $model->getSyncInstance($config)->loadFromAccountingProvider($params);
            do {
                $page = $page + 1;
                $params['page'] = $page;
                try {
                    $pagedData = $model->getSyncInstance($config)->loadFromAccountingProvider($params);
                    $collection = array_merge($pagedData, $collection);
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                    break;
                }
//                $pageCounter = $page;
            } while (true);
            // loop over insert into our database
        } catch (\Exception $exception){
            var_dump($exception->getMessage());
//            var_dump($exception->getTrace());
        }
//        var_dump('pages: '.$pageCounter);
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

    protected $accountingResource = Invoice::class;

    public function parseAccountingArray($data = [])
    {
        // TODO: Implement parseAccountingArray() method.
    }
}