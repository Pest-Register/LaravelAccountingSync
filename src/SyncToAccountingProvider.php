<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 12:30 PM
 */

namespace PestRegister\LaravelAccountingSync;


trait SyncToAccountingProvider
{
    /**
     * @var $accountingResourceInstance
     */
    protected $accountingResourceInstance;
    /**
     * The data to sync to Accounting.
     *
     * @see https://developer.intuit.com/docs/api/accounting
     * @return array
     */
    abstract public function getAccountingArray(): array;
    abstract public function parseAccountingArray($data = []);
    /**
     * Allows you to use `$model->Accounting_id` regardless of the actual column being used.
     *
     * @return null|string
     */
    public function getAccountingIdAttribute(): ? string
    {
        $accountingIdColumn = $this->accountingIdColumn ?? 'accounting_id';
        if (isset($this->attributes[$accountingIdColumn])) {
            return $this->attributes[$accountingIdColumn];
        }
        return null;
    }

    /**
     * @return null|\AccountingOnline\API\Core\HttpClients\FaultHandler
     */
    public function getLastAccountingError()
    {
        return $this->accountingResourceInstance->getError();
    }

    /**
     * Creates the model in Accounting.
     *
     * @return bool
     * @throws \Exception
     */
    public function insertToAccounting(): bool
    {
        $this->ignoreObservableEvents(['created', 'updated', 'saved']);
        $attributes = $this->getAccountingArray();
        if($this->accountingResourceInstance == null){
            throw new \Exception('Accounting connection must be made with getSyncInstance($config) first');
        }
        $resourceId = $this->accountingResourceInstance->create($attributes);
        if (!$resourceId[0] || !$resourceId[0]['accounting_id']) {
            return false;
        }
        if ($resourceId) {
            $resourceClass = get_class($this->accountingResourceInstance);
            if (array_key_exists('sync_token', $resourceId[0])) {
                if ($resourceId[0]['sync_token']) {
                    if (array_key_exists('sync_token', $this->getAttributes())) {
                        $this->sync_token = $resourceId[0]['sync_token'];
                    }
                }
            }
            if ($resourceClass == 'PestRegister\LaravelAccountingSync\Models\Invoice') {
                if (array_key_exists('invoice_data', $resourceId[0])) {
                    if ($resourceId[0]['invoice_data']) {
                        $this->parseLineItemsFromAccounting($resourceId[0]);
                    }
                }
            }
            if (array_key_exists('accounting_id', $resourceId[0])) {
                if ($resourceId[0]['accounting_id']) {
                    $this->accounting_id = $resourceId[0]['accounting_id'];
                    $this->save();
                }
            }
        }
        $this->save();
        return true;
    }

    /**
     * Updates the model in Accounting.
     *
     * @return bool
     * @throws \Exception
     */
    public function updateToAccounting(): bool
    {
        $this->ignoreObservableEvents(['created', 'updated', 'saved']);
        if (empty($this->accounting_id)) {
            return false;
        }
        if($this->accountingResourceInstance == null){
            throw new \Exception('Accounting connection must be made with getSyncInstance($config) first');
        }

        $attributes = $this->getAccountingArray();
        $resourceId = $this->accountingResourceInstance->update(array_merge(['accounting_id'=> $this->accounting_id], $attributes));
        if ($resourceId) {
            $resourceClass = get_class($this->accountingResourceInstance);
            if (array_key_exists('sync_token', $resourceId[0])) {
                if ($resourceId[0]['sync_token']) {
                    if (array_key_exists('sync_token', $this->getAttributes())) {
                        $this->sync_token = $resourceId[0]['sync_token'];
                    }
                }
            }
            if ($resourceClass == 'PestRegister\LaravelAccountingSync\Models\Invoice') {
                if (array_key_exists('invoice_data', $resourceId[0])) {
                    if ($resourceId[0]['invoice_data']) {
                        $this->parseLineItemsFromAccounting($resourceId[0]);
                    }
                }
            }
            if (array_key_exists('accounting_id', $resourceId[0])) {
                if ($resourceId[0]['accounting_id']) {
                    $this->accounting_id = $resourceId[0]['accounting_id'];
                    $this->save();
                }
            }

            if (array_key_exists('updated_at', $resourceId[0])) {
                if ($resourceId[0]['updated_at']) {
                    $this->last_sync_time = $resourceId[0]['updated_at'];
                    $this->save();
                }
            }
        }


        return $resourceId !== null;
    }

    /**
     * Syncs the model to Accounting.
     *
     * @param $config
     * @return bool
     * @throws \Exception
     */
    public function syncToAccountingProvider(): bool
    {
        if (empty($this->accounting_id)) {
            return $this->insertToAccounting();
        }
        return $this->updateToAccounting();
    }


    public function loadFromAccountingProvider($params){
        if($this->accountingResourceInstance == null){
            throw new \Exception('Accounting connection must be made with getSyncInstance($config) first');
        }
        return $this->accountingResourceInstance->get($params);
    }

    public function deleteFromAccountingProvider($params){
        if($this->accountingResourceInstance == null){
            throw new \Exception('Accounting connection must be made with getSyncInstance($config) first');
        }
        $resourceId = $this->accountingResourceInstance->delete($params);
        if ($resourceId) {
            $resourceClass = get_class($this->accountingResourceInstance);
            if (array_key_exists('sync_token', $resourceId[0])) {
                if ($resourceId[0]['sync_token']) {
                    if (array_key_exists('sync_token', $this->getAttributes())) {
                        $this->sync_token = $resourceId[0]['sync_token'];
                    }
                }
            }
            if ($resourceClass == 'PestRegister\LaravelAccountingSync\Models\Invoice') {
                if (array_key_exists('invoice_data', $resourceId[0])) {
                    if ($resourceId[0]['invoice_data']) {
                        $this->parseLineItemsFromAccounting($resourceId[0]);
                    }
                }
            }
            if (array_key_exists('accounting_id', $resourceId[0])) {
                if ($resourceId[0]['accounting_id']) {
                    $this->accounting_id = $resourceId[0]['accounting_id'];
                    $this->save();
                }
            }
        }

        return $resourceId !== null;
    }
    /**
     * Returns the class name for the Accounting resource.
     *
     * @return mixed
     * @throws \Exception
     */
    public function getAccountingResource()
    {
        if (empty($this->accountingResource)) {
            throw new \Exception('The $AccountingResource property must be set on the model.');
        }
        return $this->accountingResource;
    }

    /**
     * Return an instance of the associated Accounting resource.
     *
     * @param $config
     * @return mixed
     * @throws \ReflectionException
     */
    protected function getAccountingResourceInstance($config)
    {
        $myParameters = array ($config);

        if (empty($this->AccountingResourceInstance)) {

            $reflection = new \ReflectionClass($this->accountingResource);
            $this->accountingResourceInstance = $reflection->newInstanceArgs($myParameters);
        }
        return $this->accountingResourceInstance;
    }

    public function getSyncInstance($config){
        $this->getAccountingResourceInstance($config);
        if ($this->accountingResourceInstance == null) {
            throw new \Exception('Unable to create accounting instance');
        }
        return $this;
    }
}