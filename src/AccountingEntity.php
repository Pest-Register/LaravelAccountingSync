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
     * @param array $extraData
     * @return bool
     * @throws \Exception
     */
    private function insertToAccounting($extraData = [])
    {
        if($this->resourceConnectionInstance == null){
            throw new \Exception('Accounting connection must be instantiated first');
        }

        $attributes = $extraData ?: $this->getAccountingArray();
        $resourceId = $this->resourceConnectionInstance->create($attributes);
        if (!$resourceId || !$resourceId[0] || !$resourceId[0]['accounting_id']) {
            return null;
        }

        $accountingId = $resourceId[0]['accounting_id'] ?? null;
        $syncToken = $resourceId[0]['sync_token'] ?? null;

        $this->afterAccountingSave($accountingId, $syncToken, 'insert', $resourceId[0]);
        return $resourceId[0];
    }

    /**
     * Updates the model in Accounting.
     *
     * @param array $extraData
     * @return bool
     * @throws \Exception
     */
    private function updateToAccounting($extraData = [])
    {
        if (empty($accountingId = $this->getAccountingId())) {
            return null;
        }
        if($this->resourceConnectionInstance == null){
            throw new \Exception('Accounting connection must be instantiated first');
        }

        $attributes = $extraData ?: $this->getAccountingArray();
        $resourceId = $this->resourceConnectionInstance->update(array_merge(['accounting_id'=> $accountingId], $attributes));
        if (!$resourceId || !$resourceId[0] || !$resourceId[0]['accounting_id']) {
            return null;
        }

        $accountingId = $resourceId[0]['accounting_id'] ?? null;
        $syncToken = $resourceId[0]['sync_token'] ?? null;

        $this->afterAccountingSave($accountingId, $syncToken, 'update', $resourceId[0]);
        return $resourceId[0];
    }

    /**
     * Syncs the model to Accounting.
     *
     * @param array $extraData
     * @return bool
     * @throws \Exception
     */
    public function syncToAccountingProvider($extraData = [])
    {
        // remove direct usages of ->model
        if (empty($this->getAccountingId())) {
            return $this->insertToAccounting($extraData);
        }
        return $this->updateToAccounting($extraData);
    }

    /**
     * Fetch stored details from the accounting provider instance
     *
     * @return mixed|null
     * @throws \Exception
     */
    public function fetchFromAccountingProvider ($extraParams = []) {
        if ($this->resourceConnectionInstance == null){
            throw new \Exception('Accounting connection must be instantiated first');
        }

        $accountingId = $this->getAccountingId();
        if (!$accountingId) {
            throw new \Exception('Accounting ID does not exist for this model instance');
        }

        $payload = $this->resourceConnectionInstance->get([
            'accounting_id' => $accountingId
        ] + $extraParams);
        if (!$payload || !is_array($payload) || count($payload) < 1) {
            return null;
        }
        return $payload[0];
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
        if (empty($accountingId = $this->getAccountingId())) {
            return false;
        }
        $resourceId = $this->resourceConnectionInstance->delete(array_merge(['accounting_id'=> $accountingId], $params));
        if (!$resourceId || !$resourceId[0] || !$resourceId[0]['accounting_id']) {
            return false;
        }

        $accountingId = $resourceId[0]['accounting_id'] ?? null;
        $syncToken = $resourceId[0]['sync_token'] ?? null;

        $this->afterAccountingSave($accountingId, $syncToken, 'delete', $resourceId[0]);
        return true;
    }
}
