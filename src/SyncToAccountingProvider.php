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
        $attributes = $this->getAccountingArray();
        if($this->accountingResourceInstance == null){
            throw new \Exception('Accounting connection must be made with getSyncInstance($config) first');
        }
        $resourceId = $this->accountingResourceInstance->create($attributes);
        if (!$resourceId['0'] || $resourceId['0']['accounting_id']) {
            return false;
        }
        $this->accounting_id = $resourceId['0']['accounting_id'];
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
        if (empty($this->accounting_id)) {
            return false;
        }
        if($this->accountingResourceInstance == null){
            throw new \Exception('Accounting connection must be made with getSyncInstance($config) first');
        }
        $attributes = $this->getAccountingArray();
        return $this->accountingResourceInstance->update(array_merge(['accounting_id'=> $this->accounting_id], $attributes)) != null;
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