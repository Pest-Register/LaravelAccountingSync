<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 1:05 PM
 */

namespace PestRegister\LaravelAccountingSync;


use Illuminate\Database\Eloquent\Model;
use PestRegister\LaravelAccountingSync\Resources\Syncable;

abstract class AccountingEntity extends Model implements Syncable
{
    use SyncToAccountingProvider;
    /**
     * Database column name
     *
     * @var string
     */
    protected $accountingIdColumn = 'accounting_id';

    /**
     * The resource class from LifeOnScreen\LaravelQuickBooks\Resources.
     *
     * @var string
     */
    protected $accountingResource;
}