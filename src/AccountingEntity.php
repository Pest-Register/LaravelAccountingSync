<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dylan
 * Date: 15/05/2019
 * Time: 1:05 PM
 */

namespace PestRegister\LaravelAccountingSync;

abstract class AccountingEntity
{
    /**
     * @var ResourceConnectionInstance
     */
    private $resourceConnectionInstance;

    /**
     * The data to sync to Accounting.
     *
     * @see https://developer.intuit.com/docs/api/accounting
     * @return array
     */
    abstract public function getAccountingArray(): array;

    /**
     * Returns the accounting_id value for the model being updated
     *
     * @return mixed
     */
    abstract public function getAccountingId();

    /**
     * Save states locally after an accounting save has completed
     * @return mixed
     */
    abstract public function afterAccountingSave($accountingId, $syncToken, $mode, $payload = []);

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct ($accountingResource, $config) {
        $this->resourceConnectionInstance = new ResourceConnectionInstance($accountingResource, $config);
    }

    /**
     * Creates the model in Accounting.
     *
     * @return bool
     * @throws \Exception
     */
    private function insertToAccounting(): bool
    {
        if($this->resourceConnectionInstance == null){
            throw new \Exception('Accounting connection must be instantiated first');
        }

        $attributes = $this->getAccountingArray();
        $resourceId = $this->resourceConnectionInstance->create($attributes);
        if (!$resourceId || !$resourceId[0] || !$resourceId[0]['accounting_id']) {
            return false;
        }

        $accountingId = $resourceId[0]['accounting_id'] ?? null;
        $syncToken = $resourceId[0]['sync_token'] ?? null;

        $this->afterAccountingSave($accountingId, $syncToken, 'insert', $resourceId[0]);
        return true;
    }

    /**
     * Updates the model in Accounting.
     *
     * @return bool
     * @throws \Exception
     */
    private function updateToAccounting(): bool
    {
        if (empty($this->getAccountingId())) {
            return false;
        }
        if($this->resourceConnectionInstance == null){
            throw new \Exception('Accounting connection must be instantiated first');
        }

        $attributes = $this->getAccountingArray();
        $resourceId = $this->resourceConnectionInstance->update(array_merge(['accounting_id'=> $this->getAccountingId()], $attributes));
        if (!$resourceId || !$resourceId[0] || !$resourceId[0]['accounting_id']) {
            return false;
        }

        $accountingId = $resourceId[0]['accounting_id'] ?? null;
        $syncToken = $resourceId[0]['sync_token'] ?? null;

        $this->afterAccountingSave($accountingId, $syncToken, 'update', $resourceId[0]);
        return true;
    }

    /**
     * Syncs the model to Accounting.
     *
     * @return bool
     * @throws \Exception
     */
    public function syncToAccountingProvider(): bool
    {
        // remove direct usages of ->model
        if (empty($this->getAccountingId())) {
            return $this->insertToAccounting();
        }
        return $this->updateToAccounting();
    }

    /**
     * @param $params
     * @return bool
     * @throws \Exception
     */
    public function deleteFromAccountingProvider($params){
        if ($this->resourceConnectionInstance == null){
            throw new \Exception('Accounting connection must be instantiated first');
        }
        $resourceId = $this->resourceConnectionInstance->delete($params);
        if (!$resourceId || !$resourceId[0] || !$resourceId[0]['accounting_id']) {
            return false;
        }

        $accountingId = $resourceId[0]['accounting_id'] ?? null;
        $syncToken = $resourceId[0]['sync_token'] ?? null;

        $this->afterAccountingSave($accountingId, $syncToken, 'delete', $resourceId[0]);
        return true;
    }
}
